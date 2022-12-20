<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/user.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../helpers/render.php');

if (isset($_SESSION['email'])) {
    echo render_error_page(403, 'You are already signed in. Please sign out first.');
    return;
}

$email_err = $password_err = '';
$email = $password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    list('email' => $email, 'password' => $password) = $_POST;

    ['user' => $user, 'error' => $main_err] = authenticate_user($email, $password);

    if ($main_err === '') {
        $_SESSION['email'] = $user['email'];
        $_SESSION['type'] = $user['type'];

        header('Location: http://localhost');
        return;
    }
}

$password = '';

echo render('signin-view', [
    'page_title' => 'Sign in',
    'page_description' => 'Sign in to your account',
    'page_layout' => 'auth',
    'page_url' => '/signin/index.php',

    'email' => $email,
    'password' => $password,
    'email_err' => $email_err,
    'password_err' => $password_err
]);

