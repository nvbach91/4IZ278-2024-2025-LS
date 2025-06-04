<?php

if (preg_match('#/admin#', $_SERVER['REQUEST_URI'])) {
    require_once __DIR__ . "/../../utils/authenticate_admin.php";
    require __DIR__ . "/head_admin.php";
} else {
    require_once __DIR__ . "/../../utils/authenticate_user.php";
    require __DIR__ . "/head_user.php";
}

?>