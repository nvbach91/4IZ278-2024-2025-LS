<?php

ob_start();
$csrf->insertToken();
$csrf_token_input = ob_get_clean();

?>
<form method="get" class="my-3">
    <label for="status" class="form-label">Filter by status:</label>
    <select name="status" id="status" class="form-select" onchange="this.form.submit()">
        <option value="all" <?php if ($statusFilter === 'all') echo 'selected'; ?>>All</option>
        <option value="completed" <?php if ($statusFilter === 'completed') echo 'selected'; ?>>Completed</option>
        <option value="pending" <?php if ($statusFilter === 'pending') echo 'selected'; ?>>Pending</option>
    </select>
</form>

<?php if (empty($orders)): ?>
    <h1 class='my-4'>No orders found</h1>
<?php else: ?>
    <h1 class='my-4'>Order History</h1>
    <div class="row">  
    <?php foreach ($orders as $order) {
        $items = $orderItemsDB->getItemsByOrderId($order['order_id']);
        if ($items) {
            $total = 0;
            foreach ($items as $item) {
                $total += $item['price'] * $item['quantity'];
            }
    ?>
        <div class="col-12 mb-3">
            <details>
                <summary>
                    <div class="d-inline-flex align-items-center flex-wrap gap-2 justify-content-start">
                        <table class="w-100" style="table-layout: fixed; max-width: 500px;">
                            <tr>
                                <td style="width: 15%; text-align: left;">
                                    Order #<?php echo(htmlspecialchars($order['order_id'])) ?>
                                </td>
                                <td style="width: 32%; text-align: left;">
                                    from <?php echo(htmlspecialchars(date('d.m.Y H:i', strtotime($order['date'])))) ?>
                                </td>
                                <td style="width: 26%; text-align: left;">
                                    Total: <?php echo($total) ?> Kč
                                </td>
                                <td style="width: 27%; text-align: left;">
                                    Status:
                                    <?php if ($order['completed']==1): ?>
                                        <span class="badge bg-success">Completed</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Pending</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                        <a href="<?php echo $urlPrefix ?>/download_invoice.php?order_id=<?php echo urlencode($order['order_id']); ?>" class="btn btn-primary btn-sm d-flex align-items-center">
                            <span class="material-symbols-outlined">download</span>
                            Invoice
                        </a>
                        <div class="d-inline-flex align-items-center flex-wrap gap-2" style="vertical-align: middle;">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" class="d-flex align-items-center gap-2 mb-0 flex-wrap" style="vertical-align: middle;">
                                <?php echo $csrf_token_input ?>
                                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                <select name="completed" class="form-select w-auto" style="min-width: 120px;">
                                    <option value="1" <?php if ($order['completed']==1) echo 'selected'; ?>>Completed</option>
                                    <option value="0" <?php if ($order['completed']==0) echo 'selected'; ?>>Pending</option>
                                </select>
                                <button type="submit" name="change_status" class="btn btn-sm btn-primary">
                                    <span class="material-symbols-outlined align-middle">save</span>
                                    Change
                                </button>
                            </form>
                        </div>
                    </div>
                </summary>
                <div class="ps-3">
                    <details>
                        <?php $user = $UsersDB->fetchUserById($order['user_id']);?>
                        <summary>Customer: <?php echo isset($user['name']) ? htmlspecialchars($user['name']) : ''; ?></summary>
                        <p class="ps-3">
                            Name: <?php echo isset($user['name']) ? htmlspecialchars($user['name']) : ''; ?><br>
                            Email: <?php echo isset($user['email']) ? htmlspecialchars($user['email']) : ''; ?><br>
                            Phone: <?php echo isset($user['phone']) ? htmlspecialchars($user['phone']) : ''; ?><br>
                            Address: <?php echo isset($user['address']) ? htmlspecialchars($user['address']) : ''; ?>
                        </p>
                    </details>
                    <table class="table table-hover table-striped table-sm mt-2" id="order-<?php echo htmlspecialchars($order['order_id']); ?>">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item){ include __DIR__.'/order-history-item.php';} ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2"></th>
                                <th>Total: <?php echo($total) ?> Kč</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </details>
        </div>
    <?php
        }
    }
    ?>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <!-- Previous Page Link -->
            <?php if($pageNumber > 1):?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . $parameters . ($pageNumber - 1); ?>">
                        <span>Previous</span>
                    </a>
                </li>
            <?php endif ?>

            <!-- Page Number Links -->
            <?php for($i=0; $i<$numberOfPages; $i++): ?>
                <li class="page-item<?php echo $pageNumber-1 == $i ? ' active' : ''; ?>">
                    <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . $parameters . ($i + 1); ?>">
                        <?php echo $i+1; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Next Page Link -->
            <?php if($pageNumber < $numberOfPages):?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . $parameters . ($pageNumber + 1); ?>">
                        <span>Next</span>
                    </a>
                </li>
            <?php endif ?>
        </ul>
    </nav>
<?php endif; ?>