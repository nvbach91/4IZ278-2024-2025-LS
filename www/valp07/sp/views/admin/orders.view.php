<?php require_once __DIR__ . '/../../incl/header.php'; ?>

<main class="container py-4">
    <h2>All Orders</h2>

    <div class="border p-3 mb-3">
        <div class="row fw-bold mb-2 text-center">
            <div class="col">Order ID</div>
            <div class="col">Date</div>
            <div class="col">User Email</div>
            <div class="col">Payment</div>
            <div class="col">Status</div>
            <div class="col">Address</div>
        </div>
        <form method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by email or order ID..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="btn btn-outline-primary">Search</button>
            </div>
        </form>
        <?php foreach ($groupedOrders as $order): ?>
            <?php if (!empty($order['items'])): ?>
                <div class="border p-3 mb-3">
                    <div class="row text-center mb-3">
                        <div class="col"><?php echo $order['order_id']; ?></div>
                        <div class="col"><?php echo $order['created_at']; ?></div>
                        <div class="col"><?php echo htmlspecialchars($order['user_email'] ?? ''); ?></div>
                        <div class="col"><?php echo htmlspecialchars($order['payment_method'] ?? ''); ?></div>
                        <div class="col">
                            <form method="POST">
                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <?php
                                    $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
                                    foreach ($statuses as $status):
                                    ?>
                                        <option value="<?php echo $status; ?>" <?php echo $order['status'] === $status ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($status); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        </div>
                        <div class="col"><?php echo htmlspecialchars($order['shipping_address'] ?? ''); ?></div>
                    </div>

                    <div class="px-4">
                        <div class="row fw-semibold border-bottom pb-1">
                            <div class="col-5">Item</div>
                            <div class="col-2">Quantity</div>
                            <div class="col-2">Price</div>
                            <div class="col-3">Actions</div>
                        </div>
                        <a href="order.php?order_id=<?php echo urlencode($order['order_id']); ?>" class="text-decoration-none text-primary mb-2">View Order Details</a>

                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

    </div>
</main>

<?php require_once __DIR__ . '/../../incl/footer.php'; ?>