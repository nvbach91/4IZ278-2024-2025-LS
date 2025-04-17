<?php

require_once 'auth.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Vyprázdníme pole session
$_SESSION = array();

logout();
// Přesměrujeme uživatele na přihlašovací stránku
header("Location: login.php");
exit;
