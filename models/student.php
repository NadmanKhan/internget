<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../helpers/select-query-builder.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../helpers/insert-query-builder.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../helpers/make-string.php');

// define student related business logic

// get student by email
function get_student_by_email($email)
{
    $query = new SelectQueryBuilder();
    $query->SELECT('name', 'email', 'password')
        ->FROM('Student')
        ->WHERE('email', '=', make_string($email))
        ->LIMIT(1);
    echo $query->sql();
    $result = $query->execute();
    return $result->fetch_row();
}

// create new student
function create_student($name, $email, $password)
{
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = new InsertQueryBuilder();
    $query->INSERT_INTO('Student')
        ->COLUMNS('name', 'email', 'password')
        ->VALUES(make_string($name), make_string($email), make_string($password));
    $result = $query->execute();
    return $result;
}