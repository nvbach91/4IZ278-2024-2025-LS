<?php require_once __DIR__ . '/../../incl/header.php'; ?>
<main class="container py-4">
    <h2>Orders Detail</h2>
    <?php if (!empty($orderItems)): ?>
        <?php foreach ($orderItems as $item): ?>
            <div class="row align-items-center py-2 border-bottom">
                <div class="col-5"><?php echo htmlspecialchars($item['name'] ?? ''); ?></div>
                <div class="col-2"><?php echo (int)($item['quantity'] ?? 0); ?></div>
                <div class="col-2">$<?php echo number_format((float)($item['price'] ?? 0), 2); ?></div>
                <div class="col-3">
                    <form method="POST" onsubmit="return confirm('Delete this item?');">
                        <input type="hidden" name="delete_item_id" value="<?php echo $item['order_item_id']; ?>">
                        <button class="btn btn-sm btn-danger">Delete</button>
                        
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-muted">No items found for this order.</p>
    <?php endif; ?>
</main>
<?php require_once __DIR__ . '/../../incl/footer.php'; ?>