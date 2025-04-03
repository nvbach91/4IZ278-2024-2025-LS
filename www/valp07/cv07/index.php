<?php require __DIR__ . '/incl/header.php'; ?>
<?php require __DIR__ . '/config/global.php'; ?>
<?php require __DIR__ . '/db/ProductsDB.php'; ?>
<?php require_once __DIR__ . '/db/DatabaseConnection.php'; ?>
<?php
$productsDB = new ProductsDB();
$products = $productsDB->find();
$connection = DatabaseConnection::getPDOConnection();

function countRecords($connection, $tableName)
{
    $sql = "SELECT COUNT(*) AS numberOfRecords FROM {$tableName};";
    $statement = $connection->prepare($sql);
    $statement->execute();
    return $statement->fetchAll();
}

$numbersOfItemsPerPage = 5;
$numberOfRecords = countRecords($connection, 'cv07_goods')[0]['numberOfRecords'];
$numberOfPages = ceil($numberOfRecords / $numbersOfItemsPerPage);
$reamainingItemsOnLastPage = $numberOfRecords % $numbersOfItemsPerPage;

$pageNumber = $_GET['page'] ?? 1;
$offset = ($pageNumber - 1) * $numbersOfItemsPerPage;
$sql = "SELECT * FROM cv07_goods
            ORDER BY good_id ASC
            LIMIT $numbersOfItemsPerPage
            OFFSET $offset;";
$statement = $connection->prepare($sql);
$statement->execute();
$cv07_goods = $statement->fetchAll();
?>
<main class="container pt-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <h1 class="my-4">Shop Name</h1>
            </div>
            <div class="col-lg-9">

                <div class="row">
                    <?php foreach ($cv07_goods as $product): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $product['name']; ?></h4>
                                    <h5><?php echo number_format($product['price'], 2), ' ', GLOBAL_CURRENCY; ?></h5>
                                    <p class="card-text"><?php echo $product['description']; ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="buy.php?good_id=<?php echo $product['good_id']; ?>" class="btn btn-primary">Buy Now</a>
                                        <div>
                                            <a href="edit-item.php?good_id=<?php echo $product['good_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="delete-item.php?good_id=<?php echo $product['good_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer"><small class="text-muted">★ ★ ★ ★ ☆</small></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</main>
<nav aria-label="Page navigation" class="container my-4">
    <ul class="pagination justify-content-center">
        <?php if ($pageNumber > 1): ?>
            <li class="page-item">
                <a class="page-link" href="index.php?page=<?php echo $pageNumber - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $numberOfPages; $i++): ?>
            <li class="page-item <?php echo ($i == $pageNumber) ? 'active' : ''; ?>">
                <a class="page-link" href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
        
        <?php if ($pageNumber < $numberOfPages): ?>
            <li class="page-item">
                <a class="page-link" href="index.php?page=<?php echo $pageNumber + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
<?php require __DIR__ . '/incl/footer.php'; ?>