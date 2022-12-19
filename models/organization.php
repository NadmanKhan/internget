<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../helpers/select-query-builder.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../helpers/insert-query-builder.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../helpers/make-string.php');

// define organization related business logic

// get organization by email
function get_organization_by_email($email) {
    $query = new SelectQueryBuilder();
    $query->SELECT('name', 'email', 'password')
        ->FROM('Organization')
        ->WHERE('email', '=', make_string($email))
        ->LIMIT(1);
    echo $query->sql();
    $result = $query->execute();
    return $result->fetch_row();
}

// create new organization
function create_organization($name, $email, $password) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = new InsertQueryBuilder();
    $query->INSERT_INTO('Student')
        ->COLUMNS('name', 'email', 'password')
        ->VALUES(make_string($name), make_string($email), make_string($password));
    $result = $query->execute();
    return $result;
}
