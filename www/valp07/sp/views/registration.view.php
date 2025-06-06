<?php require __DIR__ . '/../incl/header.php'; ?>
<main class="container pt-4">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <h1 class="mb-4 text-center">Register</h1>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" novalidate>
        <div class="form-group mb-3">
          <label for="email">Email address</label>
          <input type="email" class="form-control" id="email" name="email"
            placeholder="Enter your email"
            value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <div class="form-group mb-3">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" name="name"
            placeholder="Enter your name"
            value="<?= htmlspecialchars($name) ?>" required>
        </div>

        <div class="form-group mb-3">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password"
            name="password" placeholder="Enter a password" required>
        </div>

        <div class="form-group mb-4">
          <label for="confirmPassword">Confirm Password</label>
          <input type="password" class="form-control" id="confirmPassword"
            name="confirmPassword" placeholder="Confirm your password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Register</button>
      </form>
    </div>
  </div>
</main>
<?php require __DIR__ . '/../incl/footer.php'; ?>