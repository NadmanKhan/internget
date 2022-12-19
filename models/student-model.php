<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/SelectQueryBuilder.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/InsertQueryBuilder.php');

// define student related business logic

// get student by email
function get_student_by_email($email) {
    $query = new SelectQueryBuilder();
    $query->SELECT()
        ->FROM('Student')
        ->WHERE('email', '=', $email)
        ->LIMIT(1)
        ->build()
        ->execute();
    return $query->execute();
}

// create new student
function create_student($name, $email, $password) {
    $query = new InsertQueryBuilder();
    $query->INSERT_INTO('Student')
        ->COLUMNS('name', 'email', 'password')
        ->VALUES($name, $email, $password)
        ->build()
        ->execute();
    return $query->execute();
}
