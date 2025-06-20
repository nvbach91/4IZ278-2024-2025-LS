<?php
$products=$productsWithPageOffset;

//preparation of URL parameters for pagination
if (!$_GET && !empty($productsWithPageOffset)) {
        $parameters='?page=';
} elseif(isset($_GET['page'])) {
    $parametersWithoutPage=$_GET;
    unset($parametersWithoutPage['page']);
    $parameters='?'.http_build_query($parametersWithoutPage).'&page=';
} else {
    $parameters='?'.http_build_query($_GET).'&page=';
}
?>

<?php if(empty($productsWithPageOffset)):?>
    <h2>No products found.</h2>
<?php else:
    include __DIR__.'/products-list.php'; ?>

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