<?php require __DIR__ . '/../incl/header.php'; ?>
<main class="container pt-3">
  <div class="row">
    <div class="col-md-4">
      <div class="mb-3">
        <p class="fw-bold"><?php echo $name ?></p>
      </div>
      <div class="mb-3">
        <p class="fw-bold"><?php echo $email ?></p>
      </div>
      <hr>
      <form method="POST" action="changePassword.php">
        <p>Change password</p>
        <div class="mb-3">
          <input type="password" class="form-control" name="old_password" placeholder="Old password" required>
        </div>
        <div class="mb-3">
          <input type="password" class="form-control" name="new_password" placeholder="New password" required>
        </div>
        <div class="mb-3">
          <input type="password" class="form-control" name="confirm_password" placeholder="Confirm new password" required>
        </div>
        <div class="mb-3">
          <button type="submit" class="btn btn-outline-secondary">Change Password</button>
        </div>
      </form>
      <hr>

      <?php if ($role === 'admin'): ?>
        <div class="mb-3">
          <a href="./admin/products.php" class="btn btn-outline-warning w-100">Edit Products</a>
        </div>
        <div class="mb-3">
          <a href="./admin/orders.php" class="btn btn-outline-warning w-100">Edit Orders</a>
        </div>
        <div class="mb-3">
          <a href="./admin/users.php" class="btn btn-outline-warning w-100">Edit Users</a>
        </div>
      <?php endif; ?>
    </div>

    <div class="col-md-8">
      <div class="border p-3 mb-3">
        <div class="row fw-bold mb-2 text-center">
          <div class="col">Order ID</div>
          <div class="col">Date</div>
          <div class="col">Item</div>
          <div class="col">Price</div>
          <div class="col">Status</div>
        </div>

        <?php foreach ($groupedOrders as $order): ?>
          <div class="row text-center mb-3">
            <div class="col"><?php echo htmlspecialchars($order['order_id']); ?></div>
            <div class="col"><?php echo htmlspecialchars($order['created_at']); ?></div>
            <div class="col text-start">
              <?php foreach ($order['items'] as $item): ?>
                <div>
                  <?php echo htmlspecialchars($item['product_name']); ?> (x<?php echo $item['quantity']; ?>) -
                  $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                </div>
              <?php endforeach; ?>
            </div>
            <div class="col"><?php echo htmlspecialchars($order['status']); ?></div>
          </div>
        <?php endforeach; ?>

      </div>
    </div>
  </div>
</main>
<?php require __DIR__ . '/../incl/footer.php'; ?>