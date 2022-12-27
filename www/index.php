<?php

session_start();


require_once($_SERVER['DOCUMENT_ROOT'] . '/../helpers/render.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/search-live.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/search.php');

if (isset($_GET['search'])) {
    // if live search
    if ($_GET['search'] === 'live') {

        list('name' => $name, 'value' => $value) = $_GET;

        if (!isset($name) || !isset($value)) {
            echo '[]';
            exit;
        }

        list(
            'data' => $data,
            'error' => $error
        ) = get_live_options($name, $value);

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

        // convert arrays
        $tags = $tags ?? [];
        $positions = $positions ?? [];
        $domains = $domains ?? [];
        $orgs = $orgs ?? [];
        $workplace_mode = $workplace_mode ?? [];
        $locations = $locations ?? [];

        // convert to int
        $has_bonus = $has_bonus ? 1 : 0;
        $min_pay = (int) $min_pay;
        $duration_min = (int) $duration_min;
        $duration_max = (int) $duration_max;
        $days_per_week_min = (int) $days_per_week_min;
        $days_per_week_max = (int) $days_per_week_max;
        $hours_per_week_min = (int) $hours_per_week_min;
        $hours_per_week_max = (int) $hours_per_week_max;

        // convert to date
        $start_date_min = date('Y-m-d', strtotime($start_date_min));
        $start_date_max = date('Y-m-d', strtotime($start_date_max));

        // compact into an assoc array
        $vars = compact(
            'tags',
            'positions',
            'domains',
            'orgs',
            'workplace_mode',
            'locations',
            'has_bonus',
            'min_pay',
            'start_date_min',
            'start_date_max',
            'duration_min',
            'duration_max',
            'days_per_week_min',
            'days_per_week_max',
            'hours_per_week_min',
            'hours_per_week_max',
        );

        list(
            'data' => $internships,
            'error' => $error
        ) = get_internships($vars);

        if ($error) {
            $internships = [];
        }
    }
}



echo render('internship-search-view', [
    'page' => [
        'layout' => 'default',
        'title' => 'Internship Search',
        'description' => 'Search for internships',
        'url' => '/',
        'css_sources' => [
            '/assets/css/multiselect.css',
        ],
        'js_sources' => [
            '/assets/js/cookies.js',
            '/assets/js/multiselect.js',
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
        'internships' => $internships,
    ],
]);
