<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/db.php');

// validate input
// ===========================================

// validate name
function validate_name($name)
{
    $error = '';
    if (empty($name)) {
        $error = 'Name is required';
    } else if (strlen($name) > 30) {
        $error = 'Name must be less than 30 characters';
    } else if (strlen($name) < 2) {
        $error = 'Name must be at least 2 characters';
    } else if (!preg_match('/^[\p{L}\s._-]+$/u', $name)) {
        $error = 'Name must contain only letters, spaces, and the following special characters: . _ -';
    }

    if ($error === '') {
        $name = htmlspecialchars(trim($name));
    }

    return [
        'data' => $name,
        'error' => $error
    ];
}

// validate email
function validate_email($email)
{
    $error = '';
    if (empty($email)) {
        $error = 'Email is required';
    } else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $error = 'Invalid email';
    } else if (strlen($email) > 50) {
        $error = 'Email must be less than 50 characters';
    }

    if ($error === '') {
        $email = trim($email);
    }

    return [
        'data' => $email,
        'error' => $error
    ];
}

// validate password
function validate_password($password)
{
    $error = '';
    if (empty($password)) {
        $error = 'Password is required';
    } else if (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters';
    }

    if ($error === '') {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    return [
        'data' => $hashed_password,
        'error' => $error
    ];
}

// validate confirm password
function validate_confirm_password($password, $confirm_password)
{
    $error = '';
    if (empty($confirm_password)) {
        $error = 'Please confirm your password';
    } else if ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    }

    return [
        'data' => $confirm_password,
        'error' => $error
    ];
}

// db query functions
// ===========================================

// format query string to get user by email from any table
$format_get_by_email = <<<SQL
    SELECT * 
    FROM %s
    WHERE email = ?
SQL;

// get student by email
function get_student_by_email($email)
{
    global $mysqli;
    global $format_get_by_email;

    $query = sprintf($format_get_by_email, 'Student');

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $stmt->close();
    
    $student = $result->fetch_assoc();
    return [
        'data' => $student,
        'error' => ($student ? '' : 'Student with email does not exist')
    ];
}

// get organization by email
function get_organization_by_email($email)
{
    global $mysqli;
    global $format_get_by_email;

    $query = sprintf($format_get_by_email, 'Organization');
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $organization = $result->fetch_assoc();
    return [
        'data' => $organization,
        'error' => ($organization ? '' : 'Organization with email does not exist')
    ];
}

// get user by email
function get_user_by_email($email)
{
    $user = get_student_by_email($email);
    if ($user) {
        $user['type'] = 'student';
    } else {
        $user = get_organization_by_email($email);
        if ($user) {
            $user['type'] = 'organization';
        }
    }
    return [
        'data' => $user['data'],
        'error' => ($user ? '' : 'User with email does not exist')
    ];
}

// check no user with email exists
function check_no_user_exists($email)
{
    $user = get_user_by_email($email);
    return [
        'data' => !$user['data'],
        'error' => ($user['data'] 
        ? 'User with email already exists. <a href="/signin">Sign in</a> instead?' 
        : '')
    ];
}

// authenticate user
function authenticate_user($email, $password)
{
    $user = get_user_by_email($email);
    $error = '';
    if ($user['data']) {
        $user = $user['data'];
        var_dump($user);
        var_dump($password);
        if (!password_verify($password, $user['password'])) {
            $error = 'Incorrect password';
        }
    } else {
        $error = $user['error'];
    }
    return [
        'data' => $user,
        'error' => $error
    ];
}

// format query string to insert user into any table
$format_create_user = <<<SQL
    INSERT INTO %s (name, email, password)
    VALUES (?, ?, ?)
SQL;

// create student
function create_student($name, $email, $password)
{
    global $mysqli;
    global $format_create_user;

    $query = sprintf($format_create_user, 'Student');

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sss', $name, $email, $password);
    $stmt->execute();
    
    $stmt->close();

    $error = ($mysqli->error ? $mysqli->error : '');
    $data = $error ? null : $mysqli->insert_id;
    return [
        'data' => $data,
        'error' => $error
    ];
}

// create organization
function create_organization($name, $email, $password)
{
    global $mysqli;
    global $format_create_user;

    $query = sprintf($format_create_user, 'Organization');
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sss', $name, $email, $password);
    $stmt->execute();
    
    $error = ($mysqli->error ? $mysqli->error : '');
    $data = $error ? null : $mysqli->insert_id;
    return [
        'data' => $data,
        'error' => $error
    ];
}
