<?php
require_once 'db/DbPdo.php';
require_once 'db/UserDb.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function requireLogin()
{
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

function requirePrivilege(int $minLevel)
{
    requireLogin();
    if (($_SESSION['privilege'] ?? 0) < $minLevel) {
        header('HTTP/1.1 403 Forbidden');
        echo 'Přístup odepřen.';
        exit;
    }
}

function loginUser($user)
{
    $_SESSION['user_id']   = $user->getUserId();
    $_SESSION['name']      = $user->getName();
    $_SESSION['email']     = $user->getEmail();
    $_SESSION['privilege'] = $user->getPrivilege();
}

function logout()
{
    session_unset();
    session_destroy();
}
