<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/db.php');

// define student related business logic

// get student by email
function get_student_by_email($email)
{
    global $mysqli;
    $query = <<<SQL
        SELECT name, email, password
        FROM Student
        WHERE email = ?
        LIMIT 1
SQL;
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_row();
}

// create new student
function create_student($name, $email, $password)
{
    global $mysqli;
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = <<<SQL
        INSERT INTO Student (name, email, password)
        VALUES (?, ?, ?)
SQL;
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sss', $name, $email, $password);
    $result = $stmt->execute();
    return $result;
}
