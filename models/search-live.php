<?php

require_once getenv('APP_CONFIG_DIR') . '/app.php';

function get_live_options($name, $value)
{
    global $mysqli;
    $name = trim($name);
    $value = trim($value) . '%';

    if ($name === 'locations' || $name === 'location') {
        $query = <<<SQL
    SELECT
        CONCAT(Location.city, ', ', Location.country) as labelText, 
        COUNT(*) as labelCount
    FROM Location
    WHERE
        Location.city LIKE ? 
        OR Location.country LIKE ?
        OR Location.country_iso2 LIKE ?
        OR Location.country_iso3 LIKE ?
    GROUP BY Location.city
    ORDER BY CONCAT(Location.city, ', ', Location.country)
    LIMIT 10
SQL;
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('ssss', $value, $value, $value, $value);
    } else if ($name === 'tags') {
        $query = <<<SQL
    SELECT 
        Tag.name as labelText, 
        COUNT(*) as labelCount
    FROM Tag
    WHERE Tag.name LIKE ?
    GROUP BY Tag.name
    ORDER BY Tag.name
    LIMIT 10
SQL;
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('s', $value);
    } else if ($name === 'positions') {
        $query = <<<SQL
    SELECT
        Position.name as labelText, 
        COUNT(*) as labelCount
    FROM Position
    WHERE Position.name LIKE ?
    GROUP BY Position.name
    ORDER BY Position.name
    LIMIT 10
SQL;
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('s', $value);
    } else if ($name === 'domains') {
        $query = <<<SQL
    SELECT
        Domain.name as labelText,
        COUNT(*) as labelCount
    FROM Domain
    WHERE Domain.name LIKE ?
    GROUP BY Domain.name
    ORDER BY Domain.name
    LIMIT 10
SQL;
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('s', $value);
    } else if ($name === 'orgs') {
        $query = <<<SQL
    SELECT
        Organization.name as labelText, 
        COUNT(*) as labelCount
    FROM Organization
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
        'data' => array_map(function ($item) {
            return [
                'value' => $item['labelText'],
                'label' => [
                    'text' => $item['labelText'],
                    'count' => $item['labelCount']
                ],
            ];
        }, $data),
        'error' => null,
    ];
}
