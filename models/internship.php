<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/app.php');

// validate input
// ===========================================

// validate short autocomplete field
function validate_autocomplete_text($autocomplete_text, $field_name, $is_required = false, $options = [])
{
    $error = null;
    if ($is_required && empty($autocomplete_text)) {
        $error = $field_name . ' is required';
    } else if (strlen($autocomplete_text) > 30) {
        $error = $field_name . ' must be less than 30 characters';
    } else if (strlen($autocomplete_text) < 2) {
        $error = $field_name . ' must be at least 2 characters';
    } else if (!empty($options) && !in_array($autocomplete_text, $options)) {
        $error = 'A ' . $field_name . ' is not from the list of options';
    }

    if ($error === '') {
        $autocomplete_text = trim($autocomplete_text);
    }

    return [
        'data' => $autocomplete_text,
        'error' => $error
    ];
}

// validate long text field
function validate_long_text($long_text, $field_name, $is_required = false)
{
    $error = null;
    if ($is_required && empty($long_text)) {
        $error = $field_name . ' is required';
    } else if (strlen($long_text) > 1000) {
        $error = $field_name . ' must be less than 1000 characters';
    } else if (strlen($long_text) < 2) {
        $error = $field_name . ' must be at least 2 characters';
    }

    if ($error === '') {
        $long_text = trim($long_text);
    }

    return [
        'data' => $long_text,
        'error' => $error
    ];
}

// validate numberic field
function validate_numeric($numeric, $field_name, $is_required = false, $is_integer = true, $min = 0, $max = 1000000000)
{
    $error = null;
    if ($is_required && empty($numeric)) {
        $error = $field_name . ' is required';
    } else if (!is_numeric($numeric)) {
        $error = $field_name . ' must be a number';
    } else if ($is_integer && !is_int($numeric + 0)) {
        $error = $field_name . ' must be an integer';
    } else if ($numeric < $min) {
        $error = $field_name . ' must be greater than or equal to ' . $min;
    } else if ($numeric > $max) {
        $error = $field_name . ' must be less than or equal to ' . $max;
    }

    if ($error === '') {
        $numeric = trim($numeric);
    }

    return [
        'data' => $numeric,
        'error' => $error
    ];
}

// validate enum field
function validate_enum($enum, $field_name, $is_required = false, $enum_values = [])
{
    $error = null;
    if ($is_required && empty($enum)) {
        $error = $field_name . ' is required';
    } else if (!in_array($enum, $enum_values)) {
        $error = $field_name . ' must be one of the following: ' . implode(', ', array_map(function ($value) {
            return '"' . $value . '"';
        }, $enum_values));
    }

    if ($error === '') {
        $enum = trim($enum);
    }

    return [
        'data' => $enum,
        'error' => $error
    ];
}

// validate date field
function validate_date($date, $field_name, $is_required = false)
{
    $error = null;
    if ($is_required && empty($date)) {
        $error = $field_name . ' is required';
    } else if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        $error = $field_name . ' must be a valid date of the format YYYY-MM-DD';
    } else if (strtotime($date) < strtotime('today')) {
        $error = $field_name . ' must be today or later';
    }

    if ($error === '') {
        $date = trim($date);
    }

    return [
        'data' => $date,
        'error' => $error
    ];
}

// db query functions
// ===========================================

// insert if not exists
function insert_if_not_exists(string $table, array $columns, string $types, array $values)
{
    global $mysqli;

    // if length of columns, column types and values are not equal, die with error
    if (count($columns) !== count($values) || count($columns) !== strlen($types)) {
        die('Error: length of columns, column types and values are not equal');
    }

    // query format to check if row exists
    $query = <<<SQL
        SELECT *
        FROM $table
        WHERE %s
        LIMIT 1
SQL;

    // build query
    $where_clauses = array_map(function ($column) {
        return $column . ' = ?';
    }, $columns);
    $query = sprintf($query, implode(' AND ', $where_clauses));

    // prepare, bind and execute statement
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param($types, ...$values);
    $stmt->execute();

    // get result
    $result = $stmt->get_result();

    // if row doesn't exist, insert it
    if ($result->num_rows === 0) {
        // query format to insert row
        $query = <<<SQL
            INSERT INTO $table (%s)
            VALUES (%s)
SQL;

        // build query
        $value_placeholders = implode(', ', array_fill(0, count($columns), '?'));
        $query = sprintf($query, implode(', ', $columns), $value_placeholders);

        // prepare, bind and execute statement
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param($types, ...$values);
        $stmt->execute();

        // get result
        $result = $stmt->get_result();

        // if row was inserted, return the insert id
        if ($result) {
            return [
                'data' => $mysqli->insert_id,
                'error' => null,
            ];
        }

        // else, return false with error
        return [
            'data' => false,
            'error' => 'Error: row was not inserted',
        ];
    } else {
        // if row exists, fetch it and return the id
        $row = $result->fetch_row();
        if (!$row) {
            // if row was not fetched, return false with error
            return [
                'data' => false,
                'error' => 'Error: row does not exist',
            ];
        }
        // build name of id column: lowercase table (entity) name + '_id'
        $id_column = strtolower($table) . '_id';
        // return id
        return [
            'data' => $row[$id_column],
            'error' => null,
        ];
    }
}

// create internship
// too many columns, so use an array instead of named parameters
function create_internship(array $vars)
{
    global $mysqli;

    // first, insert to referenced (one-to-many) tables if they don't exist, 
    // and store the insert ids
    list(
        'data' => $position_id,
        'error' => $error
    ) = insert_if_not_exists('Position', ['name'], 's', [$vars['position_name']]);
    
    if ($error) {
        return [
            'data' => false,
            'error' => $error
        ];
    }

    // then, insert to Internship table

    // build query
    $query = <<<SQL
        INSERT INTO Internship 
        (
            position_id, -- int, foreign key
            organization_id, -- int, foreign key 
            description, -- text
            qualifications, -- text
            responsibilities, -- text
            application_process, -- text
            contact_details, -- text
            location_id, -- int, foreign key
            hourly_pay, -- double
            has_bonus, -- boolean
            schedule, -- enum('full-time', 'part-time', 'flexible', 'project-based')
            workplace_mode, -- enum('remote', 'in-person', 'mixed')
            start_date, -- date
            duration, -- tinyint
            hours_per_week, -- tinyint
            days_per_week -- tinyint
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
SQL;

    // prepare, bind and execute statement
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param(
        'iisssssidisssiii',
        $position_id,
        $vars['organization_id'],
        $vars['description'],
        $vars['qualifications'],
        $vars['responsibilities'],
        $vars['application_process'],
        $vars['contact_details'],
        $vars['location_id'],
        $vars['hourly_pay'],
        $vars['has_bonus'],
        $vars['schedule'],
        $vars['workplace_mode'],
        $vars['start_date'],
        $vars['duration'],
        $vars['hours_per_week'],
        $vars['days_per_week']
    );
    $stmt->execute();

    // get result
    $result = $stmt->get_result();

    // if row was inserted, return the insert id
    if ($result) {
        return [
            'data' => $mysqli->insert_id,
            'error' => null,
        ];
    }

    // else, return false with error
    return [
        'data' => false,
        'error' => 'Error: row was not inserted',
    ];
}