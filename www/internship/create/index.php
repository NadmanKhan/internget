<?php

require_once getenv('APP_CONFIG_DIR') . '/app.php';
require_once getenv('APP_HELPERS_DIR') . '/render.php';
require_once getenv('APP_MODELS_DIR') . '/internship.php';

if (!isset($_SESSION['organization_id'])) {
    header('Location: /signin/');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    extract($_POST);

    list(
        'data' => $position,
        'error' => $position_error
    ) = validate_option_text($position, 'Position', true);

    if ($position_error) {
        goto RENDER;
    }

    list(
        'data' => $description,
        'error' => $description_error
    ) = validate_long_text($description, 'Description');

    if ($description_error) {
        goto RENDER;
    }

    list(
        'data' => $qualifications,
        'error' => $qualifications_error
    ) = validate_long_text($qualifications, 'Qualifications');

    if ($qualifications_error) {
        goto RENDER;
    }

    list(
        'data' => $responsibilities,
        'error' => $responsibilities_error
    ) = validate_long_text($responsibilities, 'Responsibilities');

    if ($responsibilities_error) {
        goto RENDER;
    }

    list(
        'data' => $application_process,
        'error' => $application_process_error
    ) = validate_long_text($application_process, 'Application process');

    if ($application_process_error) {
        goto RENDER;
    }

    list(
        'data' => $contact_details,
        'error' => $contact_details_error
    ) = validate_long_text($contact_details, 'Contact details');

    if ($contact_details_error) {
        goto RENDER;
    }

    $tmp = [];
    foreach ($tags as $tag) {
        $tag = trim($tag);
        list(
            'data' => $tag,
            'error' => $tag_error
        ) = validate_option_text($tag, 'Tags');
        if ($tag_error) {
            $tags_error = $tag_error;
            break;
        } else {
            $tmp[] = $tag;
        }
    }
    if (!$tags_error) {
        $tags = $tmp;
    }

    if ($tags_error) {
        goto RENDER;
    }

    $tmp = [];
    foreach ($domans as $domain) {
        $domain = trim($domain);
        list(
            'data' => $domain,
            'error' => $domain_error
        ) = validate_option_text($domain, 'Domains');
        if ($domain_error) {
            $domains_error = $domain_error;
            break;
        } else {
            $tmp[] = $domain;
        }
    }
    if (!$domains_error) {
        $domains = $tmp;
    }

    if ($domains_error) {
        goto RENDER;
    }

    list(
        'data' => $workplace_mode,
        'error' => $workplace_mode_error
    ) = validate_enum($workplace_mode, 'Workplace mode', true, ['remote', 'in-person', 'mixed']);

    if ($workplace_mode_error) {
        goto RENDER;
    }

    list(
        'data' => $location_id,
        'error' => $location_error
    ) = get_location_id($location);

    if ($location_error) {
        goto RENDER;
    }

    list(
        'data' => $hourly_pay,
        'error' => $hourly_pay_error
    ) = validate_numeric($hourly_pay, 'Hourly pay', true, false, 0, 1000);

    if ($hourly_pay_error) {
        goto RENDER;
    }

    list(
        'data' => $schedule,
        'error' => $schedule_error
    ) = validate_enum($schedule, 'Schedule', false, ['full-time', 'part-time', 'project-based', 'flexible']);

    if ($schedule_error) {
        goto RENDER;
    }

    list(
        'data' => $start_date,
        'error' => $start_date_error
    ) = validate_date($start_date, 'Start date', true);

    if ($start_date_error) {
        goto RENDER;
    }

    list(
        'data' => $duration,
        'error' => $duration_error
    ) = validate_numeric((int)$duration, 'Duration', false, true, 1, 24);

    if ($duration_error) {
        goto RENDER;
    }

    list(
        'data' => $hours_per_week,
        'error' => $hours_per_week_error
    ) = validate_numeric((int)$hours_per_week, 'Hours per week', false, false, 1, 168);

    if ($hours_per_week_error) {
        goto RENDER;
    }

    list(
        'data' => $days_per_week,
        'error' => $days_per_week_error
    ) = validate_numeric((int)$days_per_week, 'Days per week', false, false, 1, 7);

    if ($days_per_week_error) {
        goto RENDER;
    }

    $has_bonus =
        $has_bonus === 'true' ||
        $has_bonus === 'on' ||
        ($has_bonus && $has_bonus !== 'false' && $has_bonus !== 'off');
    $start_date = $start_date ? date('Y-m-d', strtotime($start_date)) : '';

    $vars = [
        'position' => $position,
        'description' => $description,
        'organization_id' => $_SESSION['organization_id'],
        'qualifications' => $qualifications,
        'responsibilities' => $responsibilities,
        'application_process' => $application_process,
        'contact_details' => $contact_details,
        'tags' => $tags,
        'domains' => $domains,
        'workplace_mode' => $workplace_mode,
        'location_id' => $location_id,
        'hourly_pay' => $hourly_pay,
        'has_bonus' => $has_bonus,
        'schedule' => $schedule,
        'start_date' => $start_date,
        'duration' => $duration,
        'hours_per_week' => $hours_per_week,
        'days_per_week' => $days_per_week,
    ];


    list(
        'data' => $internship_id,
        'error' => $main_error
    ) = create_internship($vars);

    var_dump($internship_id);
    var_dump($main_error);

    if ($main_error || !$internship_id) {
        goto RENDER;
    }

    header('Location: /');
    exit;

}

echo error_get_last();

RENDER:
echo render('internship-form-view', [
    'page' => [
        'layout' => 'default',
        'title' => 'Create Internship',
        'description' => 'Create Internship',
        'url' => '/internship/create/',
        'css_sources' => ['/assets/css/multiselect.css'],
        'js_sources' => ['/assets/js/multiselect.js'],
    ],
    'data' => [
        'position' => $position,
        'description' => $description,
        'qualifications' => $qualifications,
        'responsibilities' => $responsibilities,
        'application_process' => $application_process,
        'contact_details' => $contact_details,
        'tags' => $tags,
        'domains' => $domains,
        'workplace_mode' => $workplace_mode,
        'location' => $location,
        'hourly_pay' => $hourly_pay,
        'has_bonus' => $has_bonus,
        'schedule' => $schedule,
        'start_date' => $start_date,
        'duration' => $duration,
        'hours_per_week' => $hours_per_week,
        'days_per_week' => $days_per_week,

        'position_error' => $position_error,
        'description_error' => $description_error,
        'qualifications_error' => $qualifications_error,
        'responsibilities_error' => $responsibilities_error,
        'application_process_error' => $application_process_error,
        'contact_details_error' => $contact_details_error,
        'tags_error' => $tags_error,
        'domains_error' => $domains_error,
        'workplace_mode_error' => $workplace_mode_error,
        'location_error' => $location_error,
        'hourly_pay_error' => $hourly_pay_error,
        'has_bonus_error' => $has_bonus_error,
        'schedule_error' => $schedule_error,
        'start_date_error' => $start_date_error,
        'duration_error' => $duration_error,
        'hours_per_week_error' => $hours_per_week_error,
        'days_per_week_error' => $days_per_week_error,
        'main_error' => $main_error,
    ],
]);