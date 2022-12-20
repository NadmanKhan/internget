<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/student.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/organization.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../helpers/render.php');

// handle user signin
$email_err = $password_err = '';
$email = $password = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        $email_err = 'Email is required';
    }

    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $password_err = 'Password is required';
    }

    if (empty($email_err) && empty($password_err)) {
        $user = get_student_by_email($email);
        if (!$user) {
            $user = get_organization_by_email($email);
        }
        if ($user) {
            if (password_verify($password, $user[2])) {
                session_start();
                $_SESSION['user'] = $user;
                header('Location: /');
            } else {
                $password_err = 'Invalid password';
            }
        } else {
            $email_err = 'Invalid email';
        }
    }
}

echo render('signin-view', [
    'page_title' => 'Sign in',
    'page_description' => 'Sign in to your account',
    'page_layout' => 'auth',

    'email' => $email,
    'password' => $password,
    'email_err' => $email_err,
    'password_err' => $password_err
]);

