<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/student-model.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../functions/render.php');

// handle student signup

$name_feedback = $email_feedback = $password_feedback = $confirm_password_feedback = '';
$name = $email = $password = $confirm_password = '';

if (isset($_POST['submit'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $confirm_password = filter_var($_POST['confirm_password'], FILTER_SANITIZE_STRING);

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $email_feedback = 'Invalid email';
    } else {
        $student = get_student_by_email($email);
        if ($student) {
            $email_feedback = 'Student with this email already exists';
        }

        if (strlen($password) < 8) {
            $password_feedback = 'Password must be at least 8 characters';
        } else if ($password !== $confirm_password) {
            $confirm_password_feedback = 'Passwords do not match';
        }
        
        if ($name_feedback === '' && $email_feedback === '' && $password_feedback === '' && $confirm_password_feedback === '') {
            $query = new InsertQueryBuilder();
            $query->INSERT_INTO('Student')
                ->COLUMNS('email', 'password', 'name')
                ->VALUES($email, $password, $name)
                ->build()
                ->execute();
            header('Location: /');
            return;
        }
    }
}

$password = $confirm_password = '';

echo render('student-signup-view', [
    $page_title = 'Student Signup',
    $page_description = 'Student Signup',
    $page_layout = 'auth',

    'name' => $name,
    'email' => $email,
    'name_feedback' => $name_feedback,
    'email_feedback' => $email_feedback,
    'password_feedback' => $password_feedback,
    'confirm_password_feedback' => $confirm_password_feedback
]);
