<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../functions/render.php');

render('signin', [
    'page_layout' => 'auth',
    'page_title' => 'Signin',
    'css' => ['signin'],
]);