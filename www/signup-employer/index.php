<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/student.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/organization.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../helpers/render.php');

if (isset($_SESSION['email'])) {
    echo render_error_page(403, 'You are already signed in. Please sign out first.');
    return;
}

$name_err = $email_err = $password_err = $confirm_password_err = '';
$name = $email = $password = $confirm_password = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    list('name' => $name, 'email' => $email, 'password' => $password, 'confirm_password' => $confirm_password) = $_POST;

    list(
        'data' => $name,
        'error' => $name_err
    ) = validate_name($name);

    list(
        'data' => $email,
        'error' => $email_err
    ) = validate_email($email);

    if ($email_err !== '') {
        goto RENDER;
    }

    list('error' => $email_err) = check_no_user_exists($email);

    if ($email_err !== '') {
        goto RENDER;
    }

    list(
        'data' => $hashed_password,
        'error' => $password_err
    ) = validate_password($password);

    if ($password_err !== '') {
        goto RENDER;
    }

    list(
        'data' => $confirm_password,
        'error' => $confirm_password_err
    ) = validate_confirm_password($password, $confirm_password);

    if ($name_err === '' && $email_err === '' && $password_err === '' && $confirm_password_err === '') {
        list('error' => $main_err) = create_organization($name, $email, $hashed_password);

        if ($main_err === '') {
            header('Location: http://localhost/signin');
            return;        
        }
    }
}

$password = $confirm_password = '';

RENDER:
echo render('signup-employer-view', [
    'page_title' => 'Employer Signup',
    'page_description' => 'Sign up as an employer',
    'page_layout' => 'auth',
    'page_url' => '/signup-employer/index.php',

    'name' => $name,
    'email' => $email,
    'name_err' => $name_err,
    'email_err' => $email_err,
    'password_err' => $password_err,
    'confirm_password_err' => $confirm_password_err
]);
