<?php
// login.php
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');

    if (!$name) {
        $error = 'Zadej své jméno.';
    } else {
        setcookie('name', $name, time() + 5 * 60); // platnost 60 minut
        header('Location: index.php');
        exit();
    }
}
?>

<?php require_once 'incl/header.php'; ?>

<div class="container mt-5">
  <h2>Přihlášení</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="form-group">
      <label for="name">Jméno:</label>
      <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Přihlásit se</button>
  </form>
</div>
