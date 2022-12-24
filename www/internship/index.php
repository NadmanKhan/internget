<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/../helpers/render.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/internship.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/user.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id'])) {
        render_error_page(400, 'Invalid request; must provide an id');
        exit;
    }

    $id = $_GET['id'];

    if (!is_numeric($id)) {
        render_error_page(400, 'Invalid request; id must be a number');
        exit;
    }

    list(
        'data' => $internship,
        'error' => $internship_error
    ) = get_internship_by_id($id);

    if ($internship_error) {
        render_error_page(500, 'An error occurred while fetching the internship: ' . json_encode($internship_error));
        exit;
    }

    if (!$internship) {
        render_error_page(404, 'Internship not found');
        exit;
    }
    
    list(
        'data' => $internship['organization'],
        'error' => $main_err
    ) = get_organization_by_email($internship['organization_email']);

    if ($main_err) {
        render_error_page(500, 'An error occurred while fetching the organization: ' . json_encode($main_err));
        exit;
    }

    if (!$internship['organization']) {
        render_error_page(404, 'Organization not found');
        exit;
    }

    echo render('internship-detail-view', [
        'page_title' => "{$internship['position']} at {$internship['organization']['name']}",
        'page_description' => "Internship at {$internship['organization']['name']}",
        'page_layout' => 'default',

        'internship' => $internship,
        'user' => $_SESSION['user'] ?? null
    ]);
    
} else {
    render_error_page(400, 'Invalid request method');
    exit;
}
