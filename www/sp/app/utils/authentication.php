<?php

session_start();

function isUser() {
    if (isset($_SESSION['privilege']) && in_array($_SESSION['privilege'], [1, 2])) {
        return true;
    }
    return false;
}

function isManager() {
    if (isset($_SESSION['privilege']) && $_SESSION['privilege'] == 2) {
        return true;
    }
    return false;
}

function isAdmin() {
    if (isset($_SESSION['privilege']) && $_SESSION['privilege'] == 3) {
        return true;
    }
    return false;
}



?>