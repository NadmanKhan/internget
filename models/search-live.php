<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/db.php');


function get_live_options($name, $value)
{
    global $mysqli;
    $name = trim($name);
    $value = '%' . trim($value) . '%';

    if ($name === 'locations') {
        $query = <<<SQL
    SELECT
        CONCAT(Location.city, ', ', Location.country) as label, 
        COUNT(*) as count
    FROM Location
    WHERE
        Location.city LIKE ? 
        OR Location.country LIKE ?
        OR Location.country_iso2 LIKE ?
        OR Location.country_iso3 LIKE ?
    GROUP BY Location.city
    ORDER BY Location.city
    LIMIT 10
SQL;
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('ssss', $value, $value, $value, $value);

    } else if ($name === 'tags') {
        $query = <<<SQL
    SELECT Tag.name as label, COUNT(*) as count
    FROM Tag
    INNER JOIN InternshipTag
    ON Tag.tag_id = InternshipTag.tag_id
    WHERE Tag.name LIKE ?
    GROUP BY Tag.name
    ORDER BY Tag.name
    LIMIT 10
SQL;
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('s', $value);
    } else if ($name === 'positions') {
        $query = <<<SQL
    SELECT Position.name as label, COUNT(*) as count
    FROM Position
    INNER JOIN Internship
    ON Position.position_id = Internship.position_id
    WHERE Position.name LIKE ?
    GROUP BY Position.name
    ORDER BY Position.name
    LIMIT 10
SQL;
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('s', $value);
    } else if ($name === 'domains') {
        $query = <<<SQL
    SELECT Domain.name as label, COUNT(*) as count
    FROM Domain
    INNER JOIN Internship
    ON Domain.domain_id = Internship.domain_id
    WHERE Domain.name LIKE ?
    GROUP BY Domain.name
    ORDER BY Domain.name
    LIMIT 10
SQL;
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('s', $value);
    } else if ($name === 'orgs') {
        $query = <<<SQL
    SELECT Organization.name as label, COUNT(*) as count
    FROM Organization
    INNER JOIN Internship
    ON Organization.organization_id = Internship.organization_id
    WHERE Organization.name LIKE ?
    GROUP BY Organization.name
    ORDER BY Organization.name
    LIMIT 10
SQL;
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('s', $value);
    } else {
        return [
            'data' => [],
            'error' => 'Invalid search'
        ];
    }

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
