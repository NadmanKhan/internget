<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/db.php');

// validate input
// ===========================================

// validate short autocomplete field
function validate_autocomplete_text($autocomplete_text, $field_name, $is_required = false, $options = [])
{
    $error = '';
    if ($is_required && empty($autocomplete_text)) {
        $error = $field_name . ' is required';
    } else if (strlen($autocomplete_text) > 30) {
        $error = $field_name . ' must be less than 30 characters';
    } else if (strlen($autocomplete_text) < 2) {
        $error = $field_name . ' must be at least 2 characters';
    } else if (!preg_match('/^[\p{L}\s._-:]+$/u', $autocomplete_text)) {
        $error = 'A ' . $field_name . ' must contain only letters, spaces, and the following special characters: . _ - :';
    } else if (!empty($options) && !in_array($autocomplete_text, $options)) {
        $error = 'A ' . $field_name . ' is not from the list of options';
    }

    if ($error === '') {
        $autocomplete_text = htmlspecialchars(trim($autocomplete_text));
    }

    return [
        'data' => $autocomplete_text,
        'error' => $error
    ];
}

// validate long text field
function validate_long_text($long_text, $field_name, $is_required = false)
{
    $error = '';
    if ($is_required && empty($long_text)) {
        $error = $field_name . ' is required';
    } else if (strlen($long_text) > 1000) {
        $error = $field_name . ' must be less than 1000 characters';
    } else if (strlen($long_text) < 2) {
        $error = $field_name . ' must be at least 2 characters';
    }

    if ($error === '') {
        $long_text = htmlspecialchars(trim($long_text));
    }

    return [
        'data' => $long_text,
        'error' => $error
    ];
}

// validate numberic field
function validate_numeric($numeric, $field_name, $is_required = false, $is_integer = true, $min = 0, $max = 1000000000)
{
    $error = '';
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
        $numeric = htmlspecialchars(trim($numeric));
    }

    return [
        'data' => $numeric,
        'error' => $error
    ];
}

// validate enum field
function validate_enum($enum, $field_name, $is_required = false, $enum_values = [])
{
    $error = '';
    if ($is_required && empty($enum)) {
        $error = $field_name . ' is required';
    } else if (!in_array($enum, $enum_values)) {
        $error = $field_name . ' must be one of the following: ' . implode(', ', array_map(function ($value) {
            return '"' . $value . '"';
        }, $enum_values));
    }

    if ($error === '') {
        $enum = htmlspecialchars(trim($enum));
    }

    return [
        'data' => $enum,
        'error' => $error
    ];
}

// validate date field
function validate_date($date, $field_name, $is_required = false)
{
    $error = '';
    if ($is_required && empty($date)) {
        $error = $field_name . ' is required';
    } else if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        $error = $field_name . ' must be a valid date of the format YYYY-MM-DD';
    } else if (strtotime($date) < strtotime('today')) {
        $error = $field_name . ' must be today or later';
    }

    if ($error === '') {
        $date = htmlspecialchars(trim($date));
    }

    return [
        'data' => $date,
        'error' => $error
    ];
}

// db query functions
// ===========================================

// insert if not exists
function insert_if_not_exists($table, $column, $values)
{
    global $mysqli;

    $query = <<<SQL
    INSERT INTO $table (
        $column
    ) VALUES (
        ?
    ) ON DUPLICATE KEY UPDATE id = id
SQL;

    $stmt = $mysqli->prepare($query);
    foreach ($values as $value) {
        $stmt->bind_param('s', $value);
        $stmt->execute();
    }

    return $stmt->affected_rows;
}

// create internship
function create_internship(
    $position_name,
    $organization_email,
    $description,
    $qualifications,
    $responsibilities,
    $application_process,
    $contact_details,
    $tags,
    $domains,
    $workplace_mode,
    $city,
    $country,
    $hourly_pay,
    $has_bonus,
    $schedule,
    $start_date,
    $duration,
    $hours_per_week,
    $days_per_week
) {
    global $mysqli;

    // insert position if it doesn't already exist
    insert_if_not_exists('Position', 'position_name', [$position_name]);

    // insert tags that don't already exist
    if (!is_array($tags)) {
        $tags = explode(',', $tags);
    }
    $tags = array_map('trim', $tags);
    $tags = array_filter($tags);
    $tags = array_unique($tags);
    insert_if_not_exists('Tag', 'tag_name', $tags);

    // insert domains that don't already exist
    if (!is_array($domains)) {
        $domains = explode(',', $domains);
    }
    $domains = array_map('trim', $domains);
    $domains = array_filter($domains);
    $domains = array_unique($domains);
    insert_if_not_exists('Domain', 'domain_name', $domains);

    $query = <<<SQL
    INSERT INTO Internship (
        position_name,
        organization_email,
        description,
        qualifications,
        responsibilities,
        application_process,
        contact_details,
        workplace_mode,
        city_name,
        country_name,
        schedule,
        start_date,
        hourly_pay,
        has_bonus,
        duration,
        hours_per_week,
        days_per_week
    ) VALUES (
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?
    )
SQL;

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param(
        'ssssssssssssiiiii',
        $position_name,
        $organization_email,
        $description,
        $qualifications,
        $responsibilities,
        $application_process,
        $contact_details,
        $workplace_mode,
        $city,
        $country,
        $schedule,
        $start_date,
        $hourly_pay,
        $has_bonus,
        $duration,
        $hours_per_week,
        $days_per_week
    );
    $stmt->execute();

    $internship_id = $stmt->insert_id;

    return $internship_id;
}

// get internship by id
function get_internship_by_id($internship_id)
{
    global $mysqli;

    $query = <<<SQL
    SELECT
        i.id,
        i.position_name,
        i.organization_email,
        i.description,
        i.qualifications,
        i.responsibilities,
        i.application_process,
        i.contact_details,
        i.workplace_mode,
        i.city_name,
        i.country_name,
        i.schedule,
        i.start_date,
        i.hourly_pay,
        i.has_bonus,
        i.duration,
        i.hours_per_week,
        i.days_per_week,
        i.created_at,
        i.updated_at,
        GROUP_CONCAT(DISTINCT t.tag_name SEPARATOR ',') AS tags,
        GROUP_CONCAT(DISTINCT d.domain_name SEPARATOR ',') AS domains
    FROM Internship i
    LEFT JOIN Internship_Tag it ON it.internship_id = i.id
    LEFT JOIN Tag t ON t.id = it.tag_id
    LEFT JOIN Internship_Domain id ON id.internship_id = i.id
    LEFT JOIN Domain d ON d.id = id.domain_id
    WHERE i.id = ?
    GROUP BY i.id
SQL;

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $internship_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $internship = $result->fetch_assoc();

    // handle error
    if (!$internship) {
        return [
            'data' => [],
            'error' => 'Internship not found'
        ];
    }

    // convert tags and domains to arrays
    $internship['tags'] = explode(',', $internship['tags']);
    $internship['domains'] = explode(',', $internship['domains']);

    return [
        'data' => $internship,
        'error' => ''
    ];
}
