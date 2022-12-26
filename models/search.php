<?php


function n_question_marks($n)
{
    return implode(',', array_fill(0, $n, '?'));
}


function search(
    $tags,
    $positions,
    $domains,
    $workplace_mode,
    $orgs,
    $locations,
    $has_bonus,
    $min_pay,
    $start_date_min,
    $start_date_max,
    $duration_min,
    $duration_max,
    $days_per_week_min,
    $days_per_week_max,
) {
    global $mysqli;

    $query = <<<SQL
    SELECT
        i.internship_id as internship_id,
        p.name as position,
        o.name as organization,
        d.name as domain,
        t.name as tag,
        l.city as city,
        lcountry.name as country,
        i.hourly_pay as hourly_pay,
        i.start_date as start_date,
        i.duration as duration,
        i.days_per_week as days_per_week,
        i.has_bonus as has_bonus,
        i.description as description,
        i.requirements as requirements,
        i.application_process as application_process,
        i.contact_details as contact_details
    FROM Internship i
    INNER JOIN Position p
    ON i.position_id = p.position_id
    INNER JOIN Organization o
    ON i.organization_id = o.organization_id
    INNER JOIN InternshipTag i_t
    ON i.internship_id = i_t.internship_id
    INNER JOIN Tag t
    ON i_t.tag_id = t.tag_id
    INNER JOIN InternshipDomain i_d
    ON i.internship_id = i_d.internship_id
    INNER JOIN Domain d
    ON i_d.domain_id = d.domain_id
    INNER JOIN Location l
    ON i.location_id = l.location_id
    INNER JOIN Country lcountry
    ON l.country_iso3 = lcountry.country_iso3
    WHERE
        p.name IN(%s)
        AND o.name IN(%s)
        AND d.name IN(%s)
        AND t.name IN(%s)
        AND i.workplace_mode IN(%s)
        AND l.city IN(%s)
        AND lcountry.name IN(%s)
        AND i.has_bonus = ?
        AND i.hourly_pay >= ?
        AND i.start_date >= ?
        AND i.start_date <= ?
        AND i.duration >= ?
        AND i.duration <= ?
        AND i.days_per_week >= ?
        AND i.days_per_week <= ?
SQL;

    $query = sprintf(
        $query,
        n_question_marks(count($positions)),
        n_question_marks(count($orgs)),
        n_question_marks(count($domains)),
        n_question_marks(count($tags)),
        n_question_marks(count($workplace_mode)),
        n_question_marks(count($locations)),
        n_question_marks(count($locations))
    );

    $stmt = $mysqli->prepare($query);

    $stmt->bind_param(
        str_repeat('s', count($positions) + count($orgs) + count($domains) + 
        count($tags) + count($workplace_mode) + count($locations) * 2) . 'iiiiiiii',
        ...$positions,
        ...$orgs,
        ...$domains,
        ...$tags,
        ...$workplace_mode,
        ...$locations,
        ...$locations,
        $has_bonus,
        $min_pay,
        $start_date_min,
        $start_date_max,
        $duration_min,
        $duration_max,
        $days_per_week_min,
        $days_per_week_max
    );

    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);

    if ($data === false) {
        return [
            'data' => [],
            'error' => 'Invalid search'
        ];
    }
    return [
        'data' => $data,
        'error' => null
    ];
}
