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
        
        if ($user) {
            if (password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_email'] = $user->email;
                $_SESSION['user_name'] = $user->name;
                header('Location: /');
                exit;
            } else {
                $password_err = 'Invalid password';
            }
        } else {
            $email_err = 'Invalid email';
        }
    }
}