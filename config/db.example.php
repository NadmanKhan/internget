<?php
define('DB_HOST', 'hostname');
define('DB_USER', 'username');
define('DB_PASS', 'password');
define('DB_NAME', 'database');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
