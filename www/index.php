<?php

require_once getenv('APP_CONFIG_DIR') . '/app.php';
require_once getenv('APP_HELPERS_DIR') . '/render.php';
require_once getenv('APP_MODELS_DIR') . '/search-live.php';
require_once getenv('APP_MODELS_DIR') . '/search.php';

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
    echo 'here';

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

        var_dump($vars);

        $internships = search_internships($vars);

        var_dump($internships);
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
