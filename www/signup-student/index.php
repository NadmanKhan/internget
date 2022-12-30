<?php

require_once getenv('APP_CONFIG_DIR') . '/app.php';
require_once getenv('APP_HELPERS_DIR') . '/render.php';
require_once getenv('APP_MODELS_DIR') . '/user.php';

if (isset($_SESSION['user'])) {
    echo respond_error_page(403, 'You are already signed in. Please sign out first.');
    return;
}

$name_error = $email_error = $password_error = $confirm_password_error = $main_error = '';
$name = $email = $password = $confirm_password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    list(
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'confirm_password' => $confirm_password
    ) = $_POST;

    list(
        'data' => $name,
        'error' => $name_error
    ) = validate_name($name);

    list(
        'data' => $email,
        'error' => $email_error
    ) = validate_email($email);

    if ($email_error !== '') {
        goto RENDER;
    }

    list('error' => $email_error) = check_no_user_exists($email);

    if ($email_error !== '') {
        goto RENDER;
    }

    list(
        'data' => $hashed_password,
        'error' => $password_error
    ) = validate_password($password);

    if ($password_error !== '') {
        goto RENDER;
    }

    list(
        'data' => $confirm_password,
        'error' => $confirm_password_error
    ) = validate_confirm_password($password, $confirm_password);

    if ($name_error === '' && $email_error === '' && $password_error === '' && $confirm_password_error === '') {
        list('error' => $main_error) = create_student($name, $email, $hashed_password);

        if ($main_error === '') {
            // all okay, redirect to sign-in
            header('Location: http://localhost/signin');
            return;
        }
    }
}

$password = $confirm_password = '';

RENDER:
echo render('signup-student-view', [
    'page' => [
        'title' => 'Student Sign-up',
        'description' => 'Sign up as a student',
        'layout' => 'auth',
        'url' => '/signup-student/',
    ],
    'data' => [
        'name' => $name,
        'email' => $email,
        'name_error' => $name_error,
        'email_error' => $email_error,
        'password_error' => $password_error,
        'confirm_password_error' => $confirm_password_error,
        'main_error' => $main_error,
    ],
]);
