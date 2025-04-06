<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Vyprázdníme pole session
$_SESSION = array();

// Pokud chcete také smazat session cookie, odkomentujte následující blok
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Zničíme session
session_destroy();

// Přesměrujeme uživatele na přihlašovací stránku
header("Location: login.php");
exit;
