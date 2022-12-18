<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../functions/render.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/main.php');

$keywords = $tags = $positions = $domains =
    $skills_required = $skills_learnable = $orgs = $org_types =
    $workplace_mode = $cities = $countries = [];
$min_wage = $start_date_min = $start_date_max =
    $duration_min = $duration_max = $days_per_week_min =
    $days_per_week_max = $hours_per_week_min = $hours_per_week_max = '';



if (isset($_GET['search'])) {
    // if live search
    if ($_GET['search'] === 'live') {
        
    } 
    // if normal search
    else {

    }
}

echo render('search-view', [
    'page_layout' => 'default-layout',
    'page_title' => 'Internship Search',
    'page_description' => 'Search for internships',
    'page_js' => ['cookies'],

    'keywords' => $keywords,
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
    'min_wage' => $min_wage,
    'start_date_min' => $start_date_min,
    'start_date_max' => $start_date_max,
    'duration_min' => $duration_min,
    'duration_max' => $duration_max,
    'days_per_week_min' => $days_per_week_min,
    'days_per_week_max' => $days_per_week_max,
    'hours_per_week_min' => $hours_per_week_min,
    'hours_per_week_max' => $hours_per_week_max,
]);