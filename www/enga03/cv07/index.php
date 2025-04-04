<?php
require_once __DIR__ . '/database/DatabaseOperation.php';
require __DIR__ . '/incl/header.php';
require __DIR__ . '/incl/CardComponent.php';

$itemsPerPage = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

$dbOps = new DatabaseOperation();
$totalItems = $dbOps->fetchAllGoods(PHP_INT_MAX, 0);
$totalPages = ceil(count($totalItems) / $itemsPerPage);

$goods = $dbOps->fetchAllGoods($itemsPerPage, $offset);

?>

<main class="container">
    <h1 class="my-4">Product List</h1>
    <a href="pages/create-item.php" class="btn btn-success mb-4">Add Product</a>
    <div class="row">
        <?php foreach ($goods as $good): ?>
            <div class="col-md-4 mb-4">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="<?php echo htmlspecialchars($good['img']); ?>" alt="Product image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($good['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($good['description']); ?></p>
                        <p class="card-text"><strong><?php echo htmlspecialchars($good['price']); ?> Kč</strong></p>
                        <a href="buy.php?good_id=<?php echo $good['good_id']; ?>" class="btn btn-primary">Buy</a>
                        <a href="pages/edit-item.php?good_id=<?php echo $good['good_id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="pages/delete-item.php?good_id=<?php echo $good['good_id']; ?>" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
            </li>
        </ul>
    </nav>
</main>

<?php require __DIR__ . '/incl/footer.php'; ?>