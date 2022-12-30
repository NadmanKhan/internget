<?php

// configure and initialize everything for the server and the app

// set the default error reporting
error_reporting(E_NOTICE | E_ERROR | E_PARSE);

// configure session related settings
session_name(getenv('APP_NAME'));
ini_set('session.cookie_lifetime', 0);
ini_set('session.cookie_path', '/');
ini_set('session.cookie_domain', '');
ini_set('session.cookie_secure', false);
ini_set('session.cookie_httponly', true);
ini_set('session.use_cookies', true);
ini_set('session.use_only_cookies', true);

// start session
session_start();

// include the database configuration
require_once getenv('APP_CONFIG_DIR') . '/db.php';
