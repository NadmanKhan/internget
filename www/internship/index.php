<?php

require_once getenv('APP_CONFIG_DIR') . '/app.php';
require_once getenv('APP_HELPERS_DIR') . '/render.php';
require_once getenv('APP_MODELS_DIR') . '/internship.php';
require_once getenv('APP_MODELS_DIR') . '/user.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id'])) {
        respond_error_page(400, 'Invalid request; must provide an id');
        exit;
    }

    $id = $_GET['id'];

    if (!is_numeric($id)) {
        respond_error_page(400, 'Invalid request; id must be a number');
        exit;
    }

    if ($internship_error) {
        respond_error_page(500, 'An error occurred while fetching the internship: ' . json_encode($internship_error));
        exit;
    }

    if (!$internship) {
        respond_error_page(404, 'Internship not found');
        exit;
    }

    list(
        'data' => $internship['organization'],
        'error' => $main_error
    ) = get_organization_by_email($internship['organization_email']);

    if ($main_error) {
        respond_error_page(500, 'An error occurred while fetching the organization: ' . json_encode($main_error));
        exit;
    }

    if (!$internship['organization']) {
        respond_error_page(404, 'Organization not found');
        exit;
    }

    echo render('internship-detail-view', [
        'page' => [
            'title' => "{$internship['position']} at {$internship['organization']['name']}",
            'description' => "Internship at {$internship['organization']['name']}",
            'layout' => 'default',
        ],
        'data' => [
            'internship' => $internship,
            'user' => $_SESSION['user'] ?? null,
        ],
    ]);
} else {
    respond_error_page(400, 'Invalid request method');
    exit;
}
