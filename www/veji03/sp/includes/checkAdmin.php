<?php
if (!isset($_SESSION['user']) || empty($_SESSION['user']['is_admin'])) {
    header('Location: /sp/login.php');
    exit;
}