<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/organization.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../helpers/render.php');

// handle organization signup
$name_feedback = $email_feedback = $password_feedback = $confirm_password_feedback = '';
$name = $email = $password = $confirm_password = '';
$ok = null;

if (isset($_POST['submit'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $confirm_password = filter_var($_POST['confirm_password'], FILTER_SANITIZE_STRING);

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $email_feedback = 'Invalid email';
    } else {
        $organization = get_organization_by_email($email);
        if ($organization) {
            $email_feedback = 'Organization with this email already exists';
        }

        if (strlen($password) < 8) {
            $password_feedback = 'Password must be at least 8 characters';
        } else if ($password !== $confirm_password) {
            $confirm_password_feedback = 'Passwords do not match';
        }

        if ($name_feedback === '' && $email_feedback === '' && $password_feedback === '' && $confirm_password_feedback === '') {
            $ok = create_organization($name, $email, $password);
            if (!$ok) {
                die('Error creating organization');
            }
            header('Location: http://localhost');
            return;
        } else {
            echo 'form not valid';
            var_dump($name_feedback, $email_feedback, $password_feedback, $confirm_password_feedback);
        }
    }
}

$password = $confirm_password = '';

echo render('employer-signup-view', [
    'page_title' => 'Employer Signup',
    'page_description' => 'Employer Signup',
    'page_layout' => 'auth',

    'name' => $name,
    'email' => $email,
    'name_feedback' => $name_feedback,
    'email_feedback' => $email_feedback,
    'password_feedback' => $password_feedback,
    'confirm_password_feedback' => $confirm_password_feedback
]);
