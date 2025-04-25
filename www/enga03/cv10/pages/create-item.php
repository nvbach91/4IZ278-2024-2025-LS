<?php
session_start();
require_once __DIR__ . '/../database/ProductsDB.php';
require __DIR__ . '/../includes/header.php';

// check privileges
if (!isset($_SESSION['user_id']) || ($_SESSION['privilege'] < 2)) {
    $_SESSION['error_message'] = "You must be an administrator to add a product.";
    header('Location: ../pages/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $img = $_POST['img'];

    $productsDB = new ProductsDB();
    $productsDB->create([
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'img' => $img
    ]);

    header('Location: ../index.php');
    exit;
}
?>

<main class="container">
    <h1 class="my-4">Add Product</h1>
    <form method="POST">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="img">Image URL</label>
            <input type="text" class="form-control" id="img" name="img" required>
        </div>
        <button type="submit" class="btn btn-success">Add Product</button>
    </form>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>