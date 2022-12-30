<?php

require_once getenv('APP_CONFIG_DIR') . '/app.php';
require_once getenv('APP_HELPERS_DIR') . '/render.php';
require_once getenv('APP_MODELS_DIR') . '/user.php';

if (isset($_SESSION['email'])) {
    echo respond_error_page(403, 'You are already signed in. Please sign out first.');
    return;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    list(
        'email' => $email,
        'password' => $password,
    ) = $_POST;

    list(
        'data' => $user,
        'error' => $main_error
    ) = authenticate_user($email, $password);

    if ($user && !$main_error) {
        $_SESSION = $user;

        header('Location: http://localhost');
        return;
    }
}

$password = '';

echo render('signin-view', [
    'page' => [
        'title' => 'Sign in',
        'description' => 'Sign in to your account',
        'layout' => 'auth',
        'url' => '/signin/',
    ],
    'data' => [
        'email' => $email,
        'password' => $password,
        'email_error' => $email_error,
        'password_error' => $password_error,
        'main_error' => $main_error,
    ],
]);
