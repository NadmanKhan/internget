<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/db.php');

// define organization related business logic

// get organization by email
function get_organization_by_email($email)
{
    global $mysqli;
    $query = <<<SQL
        SELECT name, email, password
        FROM Organization
        WHERE email = ?
        LIMIT 1
SQL;
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// create new organization
function create_organization($name, $email, $password)
{
    global $mysqli;
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = <<<SQL
        INSERT INTO Organization (name, email, password)
        VALUES (?, ?, ?)
SQL;
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sss', $name, $email, $password);
    $result = $stmt->execute();
    return $result;
}
