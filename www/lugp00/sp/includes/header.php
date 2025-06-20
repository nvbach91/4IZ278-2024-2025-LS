<?php
// sp/includes/header.php

session_start();
require_once __DIR__ . '/../database/db-config.php';
require_once __DIR__ . '/../database/db-connection.php';
require_once __DIR__ . '/../database/Auth.php';

use App\DatabaseConnection;
use App\Auth;

$auth = new Auth(DatabaseConnection::getPDOConnection());
?>
<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <!-- Base href na kořen aplikace -->
  <base href="/~lugp00/sp/">
  <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'MyTasks' ?></title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">MyTasks</a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="new_task.php">Nový úkol</a></li>
        <li class="nav-item"><a class="nav-link" href="tags.php">Správa tagů</a></li>
        <li class="nav-item"><a class="nav-link" href="archived.php">Archiv úkolů</a></li>
        <li class="nav-item"><a class="nav-link" href="profile.php">Profil</a></li>
        <li class="nav-item"><a class="nav-link" href="invites.php">Pozvánky</a></li>
        <?php if ($auth->isAdmin()): ?>
          <li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li>
        <?php endif; ?>
      </ul>
      <?php if ($auth->isLoggedIn()): ?>
        <span class="navbar-text me-3"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
        <a href="logout.php" class="btn btn-outline-secondary">Odhlásit</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div class="container py-4">
