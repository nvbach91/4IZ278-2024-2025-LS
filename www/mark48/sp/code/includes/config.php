<?php

/**
 * Configuration file
 */

// Database settings
define('DB_HOST', 'localhost');
define('DB_NAME', '');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site settings
define('SITE_URL', ''); // Update with your site URL
define('ADMIN_PATH', 'admin');

// Path settings
define('ROOT_PATH', __DIR__ . '/../..');

// Session settings
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error settings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
