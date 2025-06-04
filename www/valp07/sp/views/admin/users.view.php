<?php require_once __DIR__ . '/../../incl/header.php'; ?>

<main class="container py-4">
  <h2>User Management</h2>
  <form method="GET" class="mb-3 d-flex">
    <input type="text" class="form-control me-2" name="search" placeholder="Search users by name or email..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <button type="submit" class="btn btn-outline-primary">Search</button>
  </form>

  <div class="row fw-bold text-center mb-2">
    <div class="col-1">ID</div>
    <div class="col-2">Name</div>
    <div class="col-3">Email</div>

    <div class="col-2">Role</div>
    <div class="col-2">Delete</div>
  </div>

  <?php foreach ($users as $user): ?>
    <div class="row align-items-center text-center border p-2 mb-2">
      <div class="col-1"><?php echo $user['id']; ?></div>
      <div class="col-2"><?php echo htmlspecialchars($user['name']); ?></div>
      <div class="col-3"><?php echo htmlspecialchars($user['email']); ?></div>



      <div class="col-2">
        <form method="POST">
          <input type="hidden" name="role_user_id" value="<?php echo $user['id']; ?>">
          <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
            <?php foreach (['user', 'admin'] as $role): ?>
              <option value="<?php echo $role; ?>" <?php echo $user['role'] === $role ? 'selected' : ''; ?>>
                <?php echo ucfirst($role); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </form>
      </div>

      <div class="col-2">
        <form method="POST" onsubmit="return confirm('Delete this user?');">
          <input type="hidden" name="delete_user_id" value="<?php echo $user['id']; ?>">
          <button type="submit" class="btn btn-sm btn-danger">Delete</button>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
</main>

<?php require_once __DIR__ . '/../../incl/footer.php'; ?>