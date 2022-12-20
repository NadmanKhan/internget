<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/../helpers/render.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/search.php');

$tags = $positions = $domains =
    $skills_required = $skills_learnable = $orgs =
    $workplace_mode = $cities = $countries = [];
$min_pay = $start_date_min = $start_date_max =
    $duration_min = $duration_max = $days_per_week_min =
    $days_per_week_max = $hours_per_week_min = $hours_per_week_max = '';


if (isset($_GET['search'])) {
    extract($_GET);
    // if live search
    if ($_GET['search'] === 'live') {
        
    }
    // if normal search
    else {

    }
}



echo render('internship-search-view', [
    'page_layout' => 'default',
    'page_title' => 'Internship Search',
    'page_description' => 'Search for internships',
    'page_url' => '/',
    'page_css' => ['chips-autocomplete'],
    'page_js' => ['chips-autocomplete', 'cookies'],

    'tags' => $tags,
    'positions' => $positions,
    'domains' => $domains,
    'skills_required' => $skills_required,
    'skills_learnable' => $skills_learnable,
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
]);