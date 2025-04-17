<?php
require_once "classes/Good.php";
require_once "db/GoodDb.php";

$productDb = new GoodDb();

$limit = 4; // Products per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Make sure page is at least 1

$product_count = $productDb->getTotalCount();
$number_of_pages = ceil($product_count / $limit);

$offset = ($page - 1) * $limit;
$products = $productDb->getPaginated($limit, $offset);
?>


<a href="create-item.php" class="btn btn-primary mb-3">Přidat nový produkt</a>


<nav aria-label="Page navigation" style="width: 100%;">
    <ul class="pagination">

        <!-- Previous button -->
        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= max($page - 1, 1) ?>">Previous</a>
        </li>

        <!-- Page number buttons -->
        <?php for ($i = 1; $i <= $number_of_pages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <!-- Next button -->
        <li class="page-item <?= $page >= $number_of_pages ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= min($page + 1, $number_of_pages) ?>">Next</a>
        </li>

    </ul>
</nav>


<?php
foreach ($products as $product) {

    require 'ProductCard.php';
}
?>