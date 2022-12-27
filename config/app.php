<?php

// configure and initialize everything for the server and the app

// initialize session
session_start();

// set the default session name
session_name('internget');

// include the database configuration
require_once(__DIR__ . '/db.php');

// define app constants
define('APP_NAME', 'Internget');

// define app directories
define('APP_DIR', __DIR__ . '/../');
define('APP_CONFIG_DIR', APP_DIR . 'config/');
define('APP_MODELS_DIR', APP_DIR . 'models/');
define('APP_VIEWS_DIR', APP_DIR . 'views/');
define('APP_VIEW_PARTIALS_DIR', APP_VIEWS_DIR . 'partials/');
define('APP_VIEW_LAYOUTS_DIR', APP_VIEWS_DIR . 'layouts/');

// set the default timezone
date_default_timezone_set('America/New_York');

// set the default locale
setlocale(LC_ALL, 'en_US');

// set the default encoding
mb_internal_encoding('UTF-8');

// set the default error reporting
error_reporting(E_ALL);

// set the default session cookie lifetime
ini_set('session.cookie_lifetime', 0);

// set the default session cookie path
ini_set('session.cookie_path', '/');

// set the default session cookie domain
ini_set('session.cookie_domain', '');

// set the default session cookie secure
ini_set('session.cookie_secure', false);

// set the default session cookie httponly
ini_set('session.cookie_httponly', true);

// set the default session use cookies
ini_set('session.use_cookies', true);

// set the default session use only cookies
ini_set('session.use_only_cookies', true);
