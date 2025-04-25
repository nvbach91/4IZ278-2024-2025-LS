<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: pages/auth-choice.php');
    exit;
}

require_once __DIR__ . '/database/ProductsDB.php';
require __DIR__ . '/includes/header.php';

$productsDB = new ProductsDB();
$goods = $productsDB->fetchAll();

// adding items
if (isset($_GET['buy']) && isset($_GET['good_id'])) {
    $good_id = $_GET['good_id'];
    $product = $productsDB->fetchById($good_id);

    if ($product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $_SESSION['cart'][] = $product;
        $successMessage = "Product added to cart successfully!";
    } else {
        $errorMessage = "Product not found.";
    }
}
?>

<main class="container">
    <h1 class="my-4">Product List</h1>

    <?php if (isset($successMessage)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo htmlspecialchars($successMessage); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($errorMessage)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($errorMessage); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['privilege']) && $_SESSION['privilege'] >= 2): ?>
        <a href="pages/create-item.php" class="btn btn-success mb-4">Add Product</a>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            You do not have sufficient privileges to add, edit or delete a product. Please contact an administrator if you believe this is an error.
        </div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($goods as $good): ?>
            <div class="col-md-4 mb-4">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="<?php echo htmlspecialchars($good['img']); ?>" alt="Product image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($good['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($good['description']); ?></p>
                        <p class="card-text"><strong><?php echo htmlspecialchars($good['price']); ?> Kč</strong></p>
                        <a href="?buy=1&good_id=<?php echo $good['good_id']; ?>" class="btn btn-primary">Buy</a>
                        <?php if (isset($_SESSION['privilege']) && $_SESSION['privilege'] >= 2): ?>
                            <a href="pages/edit-item.php?good_id=<?php echo $good['good_id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="pages/delete-item.php?good_id=<?php echo $good['good_id']; ?>" class="btn btn-danger">Delete</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>