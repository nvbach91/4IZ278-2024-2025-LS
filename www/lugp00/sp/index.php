<?php
// sp/index.php

session_start();

// Načteme konfiguraci DB a třídy pro spojení i Auth
require_once __DIR__ . '/database/db-config.php';
require_once __DIR__ . '/database/db-connection.php';
require_once __DIR__ . '/database/Auth.php';

use App\DatabaseConnection;
use App\Auth;

// Získáme PDO a Auth
$pdo  = DatabaseConnection::getPDOConnection();
$auth = new Auth($pdo);

// Pokud je uživatel přihlášen, přesměrujeme ho na dashboard
if ($auth->isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MyTasks – Domovská stránka</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <style>
    body { background-color: #f8f9fa; }
  </style>
</head>
<body>
  <div class="container vh-100 d-flex flex-column justify-content-center align-items-center text-center">
    <h1 class="mb-4">MyTasks</h1>
    <p class="lead mb-4">
      Jednoduchá aplikace pro správu vašich úkolů.<br>
      Vytvářejte úkoly, přiřazujte jim tagy, sdílejte je a sledujte jejich stav.
    </p>
    <div class="d-grid gap-2 col-sm-8 col-md-6 col-lg-4">
      <a href="login.php"    class="btn btn-primary btn-lg">Přihlásit se</a>
      <a href="register.php" class="btn btn-outline-primary btn-lg">Registrovat se</a>
    </div>
  </div>
</body>
</html>
