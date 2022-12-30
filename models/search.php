<?php

require_once getenv('APP_CONFIG_DIR') . '/app.php';

function search_internships($vars)
{
    global $mysqli;

    extract($vars);

    $query = <<<SQL
    SELECT
        i.internship_id as internship_id,
        CONCAT(l.city, ', ', l.country) as location,
        i.workplace_mode as workplace_mode,
        p.name as position,
        d.name as domain,
        t.name as tag,
        i.description as description,
        i.qualifications as qualifications,
        i.responsibilities as responsibilities,
        i.application_process as application_process,
        i.contact_details as contact_details
        i.start_date as start_date,
        i.duration as duration,
        i.schedule as schedule,
        i.hourly_pay as hourly_pay,
        i.has_bonus as has_bonus,
        i.hours_per_week as hours_per_week,
        i.days_per_week as days_per_week
    FROM
        Internship i
    INNER JOIN
        Position p ON i.position_id = p.position_id
    INNER JOIN
        InternshipDomain i_d ON i.internship_id = i_d.internship_id
    INNER JOIN
        Domain d ON i_d.domain_id = d.domain_id
    INNER JOIN
        InternshipTag i_t ON i.internship_id = i_t.internship_id
    INNER JOIN
        Tag t ON i_t.tag_id = t.tag_id
    INNER JOIN
        Location l ON i.location_id = l.location_id
SQL;

    $where_clauses = [];
    $types = '';
    $params = [];

    if (is_array($positions)) {
        $where_clauses[] = 'p.name IN(' .
            implode(',', array_fill(0, count($positions), '?')) .
            ')';
        $types .= str_repeat('s', count($positions));
        $params = array_merge($params, $positions);
    }

    if (is_array($domains)) {
        $where_clauses[] = 'd.name IN(' .
            implode(',', array_fill(0, count($domains), '?')) .
            ')';
        $types .= str_repeat('s', count($domains));
        $params = array_merge($params, $domains);
    }

    if (is_array($tags)) {
        $where_clauses[] = 't.name IN(' .
            implode(',', array_fill(0, count($tags), '?')) .
            ')';
        $types .= str_repeat('s', count($tags));
        $params = array_merge($params, $tags);
    }

    if (is_array($workplace_modes)) {
        $where_clauses[] = 'i.workplace_mode IN(' .
            implode(',', array_fill(0, count($workplace_modes), '?')) .
            ')';
        $types .= str_repeat('s', count($workplace_modes));
        $params = array_merge($params, $workplace_modes);
    }

    if (is_array($schedules)) {
        $where_clauses[] = 'i.schedule IN(' .
            implode(',', array_fill(0, count($schedules), '?')) .
            ')';
        $types .= str_repeat('s', count($schedules));
        $params = array_merge($params, $schedules);
    }

    if ($location_id) {
        $where_clauses[] = 'i.location_id = ?';
        $types .= 'i';
        $params[] = $location_id;
    }

    if ($min_hourly_pay) {
        $where_clauses[] = 'i.hourly_pay >= ?';
        $types .= 'd';
        $params[] = $min_hourly_pay;
    }

    if ($min_duration) {
        $where_clauses[] = 'i.duration >= ?';
        $types .= 'i';
        $params[] = $min_duration;
    }

    if ($max_duration) {
        $where_clauses[] = 'i.duration <= ?';
        $types .= 'i';
        $params[] = $max_duration;
    }

    if ($min_start_date) {
        $where_clauses[] = 'i.start_date >= ?';
        $types .= 's';
        $params[] = $min_start_date;
    }

    if ($max_start_date) {
        $where_clauses[] = 'i.start_date <= ?';
        $types .= 's';
        $params[] = $max_start_date;
    }

    if ($min_hours_per_week) {
        $where_clauses[] = 'i.hours_per_week >= ?';
        $types .= 'i';
        $params[] = $min_hours_per_week;
    }

    if ($max_hours_per_week) {
        $where_clauses[] = 'i.hours_per_week <= ?';
        $types .= 'i';
        $params[] = $max_hours_per_week;
    }

    if ($min_days_per_week) {
        $where_clauses[] = 'i.days_per_week >= ?';
        $types .= 'i';
        $params[] = $min_days_per_week;
    }

    if ($max_days_per_week) {
        $where_clauses[] = 'i.days_per_week <= ?';
        $types .= 'i';
        $params[] = $max_days_per_week;
    }

    if ($has_bonus) {
        $where_clauses[] = 'i.has_bonus = ?';
        $types .= 'i';
        $params[] = $has_bonus;
    }

    $query .= ' WHERE ' . implode(' AND ', $where_clauses);
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();

    $result = $stmt->get_result();

    $internships = [];
    while ($row = $result->fetch_assoc()) {
        $internships[] = $row;
    }

    return $internships;
}