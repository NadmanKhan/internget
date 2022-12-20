<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/student.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../helpers/render.php');

// handle student signup

$name_err = $email_err = $password_err = $confirm_password_err = '';
$name = $email = $password = $confirm_password = '';

if (isset($_POST['submit'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $confirm_password = filter_var($_POST['confirm_password'], FILTER_SANITIZE_STRING);

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $email_err = 'Invalid email';
    } else {
        $student = get_student_by_email($email);
        if ($student) {
            $email_err = 'Student with this email already exists';
        }

        if (strlen($password) < 8) {
            $password_err = 'Password must be at least 8 characters';
        } else if ($password !== $confirm_password) {
            $confirm_password_err = 'Passwords do not match';
        }

        if ($name_err === '' && $email_err === '' && $password_err === '' && $confirm_password_err === '') {
            $ok = create_student($name, $email, $password);
            if (!$ok) {
                die('Error creating student');
            }
            header('Location: http://localhost');
            return;
        }
    }
}

$password = $confirm_password = '';

echo render('student-signup-view', [
    'page_title' => 'Student Signup',
    'page_description' => 'Student Signup',
    'page_layout' => 'auth',

    'name' => $name,
    'email' => $email,
    'name_err' => $name_err,
    'email_err' => $email_err,
    'password_err' => $password_err,
    'confirm_password_err' => $confirm_password_err
]);
