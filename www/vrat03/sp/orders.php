<?php require_once __DIR__ . '/database/ProductsDB.php'; ?>
<?php require_once __DIR__ . '/database/OrdersDB.php'; ?>
<?php require_once __DIR__ . '/database/OrderItemsDB.php'; ?>

<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Status</th>
            <th>Invoice</th>
            <th>Detail</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td>
                    <?php echo(htmlspecialchars($order['order_id'])) ?>
                </td>
                <td>
                    <?php echo(htmlspecialchars(date('d.m.Y H:i', strtotime($order['date'])))) ?>
                </td>
                <td><?php if(isset($_SESSION['user']) && $_SESSION['user']['privilege'] >=2): ?>
                        <div class="d-inline-flex align-items-center flex-wrap gap-2" style="vertical-align: middle;">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" class="d-flex align-items-center gap-2 mb-0 flex-wrap" style="vertical-align: middle;" <?php if ($order['completed']==1) echo 'onsubmit="return false;"'; ?>>
                                <?php echo $csrf_token_input ?>
                                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                <select name="completed" class="form-select w-auto" style="min-width: 120px;" <?php if ($order['completed']==1) echo 'disabled'; ?>>
                                    <option value="1" <?php if ($order['completed']==1) echo 'selected'; ?>>Completed</option>
                                    <option value="0" <?php if ($order['completed']==0) echo 'selected'; ?>>Pending</option>
                                </select>
                                <button type="submit" name="change_status" class="btn btn-sm btn-primary" <?php if ($order['completed']==1) echo 'disabled'; ?>>
                                    <span class="material-symbols-outlined align-middle">save</span>
                                    Change
                                </button>
                            </form>
                        </div>
                    <?php else: ?>
                        <?php if ($order['completed']==1): ?>
                            <span class="badge bg-success">Completed</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Pending</span>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?php echo $urlPrefix ?>/download_invoice.php?order_id=<?php echo urlencode($order['order_id']); ?>" target="_blank" class="btn btn-primary btn-sm">
                        <span class="material-symbols-outlined">download</span>
                    </a>
                </td>
                <td>
                    <a href="<?php echo $urlPrefix; ?>/order-items.php?id=<?php echo urlencode($order['order_id']); ?>" class="btn btn-secondary btn-sm">
                        <span class="material-symbols-outlined">list_alt</span>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>