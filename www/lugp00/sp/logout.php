<?php
// sp/logout.php

require_once __DIR__ . '/database/db-config.php';
require_once __DIR__ . '/database/db-connection.php';
require_once __DIR__ . '/database/Auth.php';

use App\DatabaseConnection;
use App\Auth;

$auth = new Auth(DatabaseConnection::getPDOConnection());
$auth->logout();

header('Location: login.php');
exit;
