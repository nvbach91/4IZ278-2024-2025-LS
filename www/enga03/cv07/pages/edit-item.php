<?php
require_once __DIR__ . '/../database/DatabaseOperation.php';
require __DIR__ . '/../incl/header.php';

$dbOps = new DatabaseOperation();

if (isset($_GET['good_id'])) {
    $good_id = $_GET['good_id'];
    $product = $dbOps->fetchGoodById($good_id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $img = $_POST['img'];

        $dbOps->updateGood($good_id, $name, $description, $price, $img);

        header('Location: ../index.php');
        exit;
    }
} else {
    header('Location: ../index.php');
    exit;
}
?>

<main class="container">
    <h1 class="my-4">Edit Product</h1>
    <form method="POST">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        </div>
        <div class="form-group">
            <label for="img">Image URL</label>
            <input type="text" class="form-control" id="img" name="img" value="<?php echo htmlspecialchars($product['img']); ?>" required>
        </div>
        <button type="submit" class="btn btn-warning">Update Product</button>
    </form>
</main>

<?php require __DIR__ . '/../incl/footer.php'; ?>