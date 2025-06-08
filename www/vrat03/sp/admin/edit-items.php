<?php include __DIR__.'/../prefix.php'; ?>
<?php include __DIR__.'/../privileges.php'; ?>
<?php require_once __DIR__ .'/../vendor/autoload.php'; ?>
<?php require_once __DIR__ . '/../database/ProductsDB.php'; ?>
<?php

hasPrivilege(2);
$csrf = new \ParagonIE\AntiCSRF\AntiCSRF;
$productsDB = new ProductsDB();

//pagination
$isSelectedPage = !empty($_GET['page']);
$numberOfItemsPerPage=25;
$numberOfRecords=$productsDB->countRecords([]);
$numberOfPages=ceil($numberOfRecords/$numberOfItemsPerPage);
$remainingOnTheLastPage=$numberOfRecords%$numberOfItemsPerPage;
$webPageNumber=$isSelectedPage ? $_GET['page'] : 1;
$pageNumber = $webPageNumber > $numberOfPages ? 1 : $webPageNumber;
$offset=($pageNumber-1)*$numberOfItemsPerPage;
$productsWithPageOffset = $productsDB->fetchPagination($offset, $numberOfItemsPerPage);
$products = $productsWithPageOffset;
?>
<?php require __DIR__.'/../includes/head.php';?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="my-4">Edit items</h1>
        <a href="<?php echo $urlPrefix ?>/admin/add-item.php" class="btn btn-success d-flex align-items-center">
            <span class="material-symbols-outlined">add_circle</span>
            Add new product
        </a>
    </div>
    
    <div class="row">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantiy</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['product_id']) ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['price']) ?> Kč</td>
                    <td><?= htmlspecialchars($product['quantity']) ?></td>
                    <td>
                        <a href="<?php echo $urlPrefix ?>/admin/edit-item.php?id=<?= urlencode($product['product_id']) ?>" class="btn btn-secondary btn-sm">
                            <span class="material-symbols-outlined align-middle">edit</span>
                            Edit
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <!-- Previous Page Link -->
                <?php if($pageNumber > 1):?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . '?page=' . ($pageNumber - 1); ?>">
                            <span>Previous</span>
                        </a>
                    </li>
                <?php endif ?>

                <!-- Page Number Links -->
                <?php for($i=0; $i<$numberOfPages; $i++): ?>
                    <li class="page-item<?php echo $pageNumber-1 == $i ? ' active' : ''; ?>">
                        <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . '?page=' . ($i + 1); ?>">
                            <?php echo $i+1; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Next Page Link -->
                <?php if($pageNumber < $numberOfPages):?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . '?page=' . ($pageNumber + 1); ?>">
                            <span>Next</span>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </nav>
    </div>
</div>

<?php require __DIR__.'/../includes/foot.php';?>