<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Lexio</title>
</head>
<body>

<header class="bg-dark text-white py-3">
    <div class="container">
        <a href="<?php echo BASE_URL . "/home";?>" class="text-white fw-bold text-decoration-none me-3">Home</a>
        <a href="<?php echo BASE_URL . "/profile"; ?>" class="text-white fw-bold text-decoration-none">Profile</a>
    </div>
</header>

<nav class="bg-secondary">
    <div class="container">
        <ul class="nav">
            <li class="nav-item"><a class="nav-link text-white" href="<?php echo BASE_URL . "/words"; ?>">Words</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="<?php echo BASE_URL . "/collections"; ?>">Collections</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="<?php echo BASE_URL . "/stats"; ?>">Stats</a></li>
        </ul>
    </div>
</nav>