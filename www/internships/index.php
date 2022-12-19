<?php

if (!isset($_GET['id'])) {
    header('Location: /');
    exit();
}

// require the render function
require_once($_SERVER['DOCUMENT_ROOT'] . '/../functions/render.php');

// require the internship model
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/internship-model.php');

echo render('internship-detail-view', [
    'page_layout' => 'default',
    'page_title' => 'Internship Detail',
    'page_description' => 'Internship Detail',

    // 'internship' => get_internship($_GET['id']),
]);