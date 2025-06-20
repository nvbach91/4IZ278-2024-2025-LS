<?php
// sp/login.php

session_start();

// nejdříve načteme DB config, pak spojení i Auth
require_once __DIR__ . '/database/db-config.php';
require_once __DIR__ . '/database/db-connection.php';
require_once __DIR__ . '/database/Auth.php';

use App\DatabaseConnection;
use App\Auth;

$pdo  = DatabaseConnection::getPDOConnection();
$auth = new Auth($pdo);

// pokud je už přihlášený, odhlásíme ho
if ($auth->isLoggedIn()) {
    $auth->logout();
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if ($auth->login($email, $pass)) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Neplatný e-mail nebo heslo.';
    }
}
?><!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <title>Přihlášení</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <style>
    body { background-color: #f8f9fa; }
    .login-card { max-width: 420px; margin: 80px auto; }
  </style>
</head>
<body>
  <div class="login-card">
    <div class="card shadow-sm">
      <div class="card-body">

        <h3 class="card-title text-center mb-4">Přihlášení</h3>

        <?php if ($error): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- standardní formulář -->
        <form method="post" novalidate>
          <div class="mb-3">
            <input
              type="email"
              name="email"
              class="form-control"
              placeholder="E-mail"
              required
              value="<?= htmlspecialchars($email) ?>"
            >
          </div>
          <div class="mb-4">
            <input
              type="password"
              name="password"
              class="form-control"
              placeholder="Heslo"
              required
            >
          </div>
          <div class="d-grid gap-2 mb-3">
            <button type="submit" class="btn btn-primary">Přihlásit se</button>
          </div>
        </form>

        <!-- tlačítko Google OAuth -->
        <div class="d-grid">
          <a href="google_login.php" class="btn btn-outline-danger">
            Přihlásit se přes Google
          </a>
        </div>

        <div class="text-center mt-3">
          <a href="register.php">Registrovat se</a>
        </div>

      </div>
    </div>
  </div>
</body>
</html>
