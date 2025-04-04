<?php

session_start();

if ($_SESSION['privilege'] < 3) {
    echo 'Unauthorized access';
    exit;
}

echo 'Users management page';
?>