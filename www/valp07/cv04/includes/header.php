<?php
require_once __DIR__ . '/../config/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
</head>

<body>
<div class="container text-center mt-5">
    <h1 class="display-4 text-primary">CV04</h1>
</div>
<nav class="navbar navbar-light bg-light">
    <div class="container">
        <div>
        <a class="btn btn-outline-primary btn-sm" href="<?= BASE_URL ?>index.php">Home</a>
<a class="btn btn-outline-primary btn-sm" href="<?= BASE_URL ?>registration.php">Registration</a>
<a class="btn btn-outline-primary btn-sm" href="<?= BASE_URL ?>login.php">Login</a>
        </div>
    </div>
</nav>