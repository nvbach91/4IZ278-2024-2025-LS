<?php

session_start();

if ($_SESSION['privilege'] < 2) {
    echo 'Unauthorized access';
    exit;
}

echo 'Catalog management page';
?>