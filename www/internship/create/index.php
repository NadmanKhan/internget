<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/../helpers/render.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/internship.php');

if (!isset($_SESSION['user'])) {
    respond_error_page(403, 'You must be signed in as an employer (organization) to create an internship');
    exit;
}

if (isset($_GET['search']) && $_GET['search'] === 'live') {


    exit;
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $position = $_POST['position'];
    $description = $_POST['description'];
    $qualifications = $_POST['qualifications'];
    $responsibilities = $_POST['responsibilities'];
    $application_process = $_POST['application_process'];
    $contact_details = $_POST['contact_details'];
    $tags = $_POST['tags'];
    $domains = $_POST['domains'];
    $workplace_mode = $_POST['workplace_mode'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $hourly_pay = $_POST['hourly_pay'];
    $has_bonus = $_POST['has_bonus'];
    $schedule = $_POST['schedule'];
    $start_date = $_POST['start_date'];
    $duration = $_POST['duration'];
    $hours_per_week = $_POST['hours_per_week'];
    $days_per_week = $_POST['days_per_week'];

    list(
        'data' => $position,
        'error' => $position_error
    ) = validate_autocomplete_text($position, 'Position', true);

    list(
        'data' => $description,
        'error' => $description_error
    ) = validate_long_text($description, 'Description');

    list(
        'data' => $qualifications,
        'error' => $qualifications_error
    ) = validate_long_text($qualifications, 'Qualifications');

    list(
        'data' => $responsibilities,
        'error' => $responsibilities_error
    ) = validate_long_text($responsibilities, 'Responsibilities');

    list(
        'data' => $application_process,
        'error' => $application_process_error
    ) = validate_long_text($application_process, 'Application process');

    list(
        'data' => $contact_details,
        'error' => $contact_details_error
    ) = validate_long_text($contact_details, 'Contact details');

    $tmp = [];
    foreach (explode(',', $tags) as $tag) {
        $tag = trim($tag);
        list(
            'data' => $tag,
            'error' => $tag_error
        ) = validate_autocomplete_text($tag, 'Tags');
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

    $tmp = [];
    foreach (explode(',', $domains) as $domain) {
        $domain = trim($domain);
        list(
            'data' => $domain,
            'error' => $domain_error
        ) = validate_autocomplete_text($domain, 'Domains');
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

    list(
        'data' => $workplace_mode,
        'error' => $workplace_mode_error
    ) = validate_enum($workplace_mode, true, 'Workplace mode', ['remote', 'in-person', 'mixed']);

    list(
        'data' => $city,
        'error' => $city_error
    ) = validate_autocomplete_text($city, 'City');

    list(
        'data' => $country,
        'error' => $country_error
    ) = validate_autocomplete_text($country, 'Country');

    list(
        'data' => $hourly_pay,
        'error' => $hourly_pay_error
    ) = validate_numeric($hourly_pay, 'Hourly pay', true, false, 0, 1000);

    list(
        'data' => $has_bonus,
        'error' => $has_bonus_error
    ) = validate_enum($has_bonus, 'Has bonus', false, ['true', 'false', '']);

    list(
        'data' => $schedule,
        'error' => $schedule_error
    ) = validate_enum($schedule, 'Schedule', false, ['full-time', 'part-time', 'project-based', 'flexible']);

    list(
        'data' => $start_date,
        'error' => $start_date_error
    ) = validate_date($start_date, 'Start date', true);

    list(
        'data' => $duration,
        'error' => $duration_error
    ) = validate_numeric($duration, 'Duration', true, true, 1, 24);

    list(
        'data' => $hours_per_week,
        'error' => $hours_per_week_error
    ) = validate_numeric($hours_per_week, 'Hours per week', true, true, 1, 168);

    list(
        'data' => $days_per_week,
        'error' => $days_per_week_error
    ) = validate_numeric($days_per_week, 'Days per week', true, true, 1, 7);

    if (!$position_error && !$description_error && !$qualifications_error && !$responsibilities_error && !$application_process_error && !$contact_details_error && !$tags_error && !$domains_error && !$workplace_mode_error && !$city_error && !$country_error && !$hourly_pay_error && !$has_bonus_error && !$schedule_error && !$start_date_error && !$duration_error && !$hours_per_week_error && !$days_per_week_error) {

        $has_bonus = $has_bonus === 'true' ? true : false;
        $start_date = $start_date ? date('Y-m-d', strtotime($start_date)) : '';

        $organization_email = $_SESSION['user']['email'];

        if ($internship_id_error) {
            $error = $internship_id_error;
        } else {
            header('Location: /internship/?id=' . $internship_id);
            exit;
        }
    }

    exit;
}

echo render('internship-form-view', [
    'page' => [
        'layout' => 'default',
        'title' => 'Create Internship',
        'description' => 'Create Internship',
        'url' => '/internship/create/',
        'css_sources' => ['/assets/css/multiselect.css'],
        'js_sources' => ['/assets/js/multiselect.js'],
    ],
]);
