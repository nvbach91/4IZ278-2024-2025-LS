<?php
require_once __DIR__ . '/../database/ProductsDB.php';
session_start();
unset($_SESSION['errors']);
if (!isset($_SESSION['privilege']) || $_SESSION['privilege'] < 2) {
    header("Location: index.php");
    exit;
}
$productsDB = new ProductsDB();
$products = $productsDB->fetchAll();

$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($searchQuery !== '') {
    $products = array_filter($products, function ($product) use ($searchQuery) {
        return stripos($product['name'], $searchQuery) !== false;
    });
}
?>
<?php include __DIR__ . "\../includes/header.php"; ?>
<?php if (isset($_SESSION["success"])): ?>
    <div class='alert alert-success' role='alert'>
        <?php echo $_SESSION["success"]; ?>
    </div>
<?php endif; ?>
<div class="container">
    <div class="text-start my-4">
        <a href="adminProducts.php" class="btn btn-primary btn-lg mx-2">Manage Products</a>
        <a href="adminOrders.php" class="btn btn-primary btn-lg mx-2">Manage Orders</a>
        <?php if ($_SESSION['privilege'] == 3): ?>
            <a href="adminUsers.php" class="btn btn-primary btn-lg mx-2">Manage Users</a>
        <?php endif; ?>
    </div>
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <?php
    $itemsPerPage = 20;
    $totalItems = count($products);
    $totalPages = ceil($totalItems / $itemsPerPage);
    $currentPage = isset($_GET['page']) ? max(1, min($totalPages, intval($_GET['page']))) : 1;
    $offset = ($currentPage - 1) * $itemsPerPage;
    $paginatedProducts = array_slice($products, $offset, $itemsPerPage);
    ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paginatedProducts as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['id']); ?></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                    <td><?php echo htmlspecialchars($product['price']); ?></td>
                    <td><?php echo htmlspecialchars($product['stock']); ?></td>
                    <td>
                        <a href="editProduct.php?id=<?php echo urlencode($product['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="deleteProduct.php?id=<?php echo urlencode($product['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Remove</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                <li class="page-item <?php echo $page == $currentPage ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page; ?>&search=<?php echo urlencode($searchQuery); ?>"><?php echo $page; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
<div style="margin-bottom: 30px"></div>
<?php include __DIR__ . "\../includes/footer.php"; ?>