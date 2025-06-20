<?php
// sp/register.php

require_once __DIR__ . '/database/db-config.php';
require_once __DIR__ . '/database/db-connection.php';
require_once __DIR__ . '/database/User.php';

use App\DatabaseConnection;
use App\User;

$userModel = new User(DatabaseConnection::getPDOConnection());

$errors = [];
$name   = '';
$email  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = trim($_POST['name'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $pass   = $_POST['password'] ?? '';
    $pass2  = $_POST['password_confirm'] ?? '';

    // validace
    if ($name === '')       $errors[] = 'Jméno je povinné.';
    if ($email === '')      $errors[] = 'E-mail je povinný.';
    if ($pass === '')       $errors[] = 'Heslo je povinné.';
    if ($pass !== $pass2)   $errors[] = 'Hesla se neshodují.';
    if ($email && $userModel->exists($email)) {
        $errors[] = 'Uživatel s tímto e-mailem již existuje.';
    }

    if (empty($errors)) {
        if ($userModel->create($name, $email, $pass)) {
            header('Location: login.php');
            exit;
        }
        $errors[] = 'Registrace selhala, zkuste to prosím znovu.';
    }
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <title>Registrace</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
</head>
<body class="bg-light">
  <div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow-sm" style="max-width: 380px; width:100%;">
      <div class="card-body">
        <h3 class="card-title text-center mb-4">Registrace</h3>

        <?php if ($errors): ?>
          <div class="alert alert-danger py-2">
            <ul class="mb-0">
              <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <form method="post" novalidate>
          <div class="mb-3">
            <input
              type="text"
              name="name"
              class="form-control form-control-lg"
              placeholder="Jméno"
              required
              value="<?= htmlspecialchars($name) ?>"
            >
          </div>
          <div class="mb-3">
            <input
              type="email"
              name="email"
              class="form-control form-control-lg"
              placeholder="E-mail"
              required
              value="<?= htmlspecialchars($email) ?>"
            >
          </div>
          <div class="mb-3">
            <input
              type="password"
              name="password"
              class="form-control form-control-lg"
              placeholder="Heslo"
              required
            >
          </div>
          <div class="mb-4">
            <input
              type="password"
              name="password_confirm"
              class="form-control form-control-lg"
              placeholder="Znovu heslo"
              required
            >
          </div>
          <div class="d-grid gap-2 mb-3">
            <button type="submit" class="btn btn-success btn-lg">Registrovat se</button>
          </div>
        </form>

        <div class="text-center">
          <a href="login.php" class="btn btn-link">Zpět na přihlášení</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
