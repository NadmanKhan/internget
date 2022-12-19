<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/SelectQueryBuilder.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/InsertQueryBuilder.php');

// define organization related business logic

// get organization by email
function get_organization_by_email($email) {
    $query = new SelectQueryBuilder();
    $query->SELECT()
        ->FROM('Organization')
        ->WHERE('email', '=', $email)
        ->LIMIT(1)
        ->build()
        ->execute();
    return $query->execute();
}

// create new organization
function create_organization($name, $email, $password) {
    $query = new InsertQueryBuilder();
    $query->INSERT_INTO('Organization')
        ->COLUMNS('name', 'email', 'password')
        ->VALUES($name, $email, $password)
        ->build()
        ->execute();
    return $query->execute();
}
