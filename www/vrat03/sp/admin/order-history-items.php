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
        <?php include __DIR__.'/../orders.php'; ?>
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