<?php

session_start();


require_once($_SERVER['DOCUMENT_ROOT'] . '/../helpers/render.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/search-live.php');

if (isset($_GET['search'])) {
    // if live search
    if ($_GET['search'] === 'live') {

        list('field' => $field, 'value' => $value) = $_GET;

        if (!isset($field) || !isset($value)) {
            echo '[]';
            exit;
        }

        list(
            'data' => $data,
            'error' => $error
        ) = get_live_options($field, $value);

        if ($error) {
            echo '[]';
            exit;
        }

        echo json_encode($data);
        exit;
    }

    // if normal search
    else {
        extract($_GET);



        list(
            'data' => $internships,
            'error' => $error
        ) = search($tags, $positions, $domains, $orgs, $workplace_mode, $cities, $countries, $min_pay, $start_date_min, $start_date_max, $duration_min, $duration_max, $hours_per_week_min, $hours_per_week_max, $days_per_week_min, $days_per_week_max, $schedule, $has_bonus, $page, $limit);
    }
}



echo render('internship-search-view', [
    'page' => [
        'layout' => 'default',
        'title' => 'Internship Search',
        'description' => 'Search for internships',
        'url' => '/',
        'css_files' => [
            '/assets/css/multiselect.css',
        ],
        'js_files' => [
            '/assets/js/multiselect.js',
            '/assets/js/cookies.js',
        ],
    ],
    'data' => [
        'tags' => $tags,
        'positions' => $positions,
        'domains' => $domains,
        'orgs' => $orgs,
        'org_types' => $orgs,
        'workplace_mode' => $workplace_mode,
        'cities' => $cities,
        'countries' => $countries,
        'min_pay' => $min_pay,
        'start_date_min' => $start_date_min,
        'start_date_max' => $start_date_max,
        'duration_min' => $duration_min,
        'duration_max' => $duration_max,
        'days_per_week_min' => $days_per_week_min,
        'days_per_week_max' => $days_per_week_max,
        'hours_per_week_min' => $hours_per_week_min,
        'hours_per_week_max' => $hours_per_week_max,
    ],
]);
