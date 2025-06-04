<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Lexium</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <div class="container-fluid">
        <a href="<?php echo BASE_URL . "/logout"; ?>" class="btn btn-outline-light me-3">Log out</a>

        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL . "/admin/words"; ?>">Words</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL . "/admin/languages"; ?>">Languages</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL . "/admin/users"; ?>">Users</a></li>
        </ul>
    </div>
</nav>