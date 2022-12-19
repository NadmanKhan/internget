<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../helpers/query-builder.php');

function autocomplete_options($field, $value)
{
    $query = new SelectQueryBuilder();
    switch ($field) {
        case 'tags':
            $query->SELECT('name')
                ->FROM('Tag')
                ->WHERE('name', 'LIKE', "'$value%'");
            break;
        case 'positions':
            $query->SELECT('name')
                ->FROM('Position')
                ->WHERE('name', 'LIKE', "'$value%'");
            break;
        case 'domains':
            $query->SELECT('name')
                ->FROM('Domain')
                ->WHERE('name', 'LIKE', "'$value%'");
            break;
        case 'skills_required':
            $query->SELECT('name')
                ->FROM('Skill')
                ->WHERE('name', 'LIKE', "'$value%'");
            break;
        case 'skills_learnable':
            $query->SELECT('name')
                ->FROM('Skill')
                ->WHERE('name', 'LIKE', "'$value%'");
            break;
        case 'orgs':
            $query->SELECT('name')
                ->FROM('Organization')
                ->WHERE('name', 'LIKE', "'$value%'");
            break;
        case 'workplace_mode':
            $query->SELECT('workplace_mode')
                ->FROM('Internship')
                ->WHERE('workplace_mode', 'LIKE', "'$value%'");
            break;
        case 'cities':
            $query->SELECT('city')
                ->FROM('Internship')
                ->WHERE('city', 'LIKE', "'$value%'");
            break;
        case 'countries':
            $query->SELECT('country')
                ->FROM('Internship')
                ->WHERE('country', 'LIKE', "'$value%'");
            break;
        default:
            return [];
    }
    $result = $query->execute();
    $rows = [];
    while ($row = $result->fetch_row()) {
        $rows[] = $row[0];
    }
    return $rows;
}