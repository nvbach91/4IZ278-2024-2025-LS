<?php
require_once __DIR__ . '/saveProduct.php';
@session_start();

if ($_SESSION['privilege'] < '2') {
    header("Location: /../index.php");
    exit;
}

require_once __DIR__ . '/../database/ProductsDB.php';
$productDB = new ProductsDB();

if (!isset($_GET["id"])) {
    header("Location: /../index.php");
    exit;
}
$productId = $_GET["id"];
$product = $productDB->fetchById($productId);
if (!$product) {
    header("Location: /../index.php");
    exit;
}
if (isset($_SESSION["errors"])) {
    $errors = $_SESSION["errors"];
}
$_SESSION["timestamp"] = $product["last_updated"];
?>

<?php include __DIR__ . '/../includes/header.php'; ?>
<main class="container">
    <?php if (isset($errors["timestamp"])): ?>
        <div class='alert alert-danger' role='alert'>
            <?php echo $errors["timestamp"]; ?>
        </div>
    <?php endif; ?>
    <form action=<?php echo "saveProduct.php" . "?id=" . $productId ?> method="POST" class="form-register">
        <h1>Edit</h1>
        <form method="POST">
            <div class="form-group">
                <?php if (isset($errors["name"])): ?>
                    <div class='alert alert-danger' role='alert'>
                        <?php echo $errors["name"]; ?>
                    </div>
                <?php endif; ?>
                <label for="name">Name</label>
                <input class="form-control" id="name" value="<?= $product["name"]; ?>" name="name" placeholder="Name">

                <?php if (isset($errors["price"])): ?>
                    <div class='alert alert-danger' role='alert'>
                        <?php echo $errors["price"]; ?>
                    </div>
                <?php endif; ?>
                <label for="price">Price</label>
                <input class="form-control" id="price" value="<?= $product["price"]; ?>" name="price" placeholder="Price">

                <?php if (isset($errors["description"])): ?>
                    <div class='alert alert-danger' role='alert'>
                        <?php echo $errors["description"]; ?>
                    </div>
                <?php endif; ?>
                <label for="description">Description</label>
                <input class="form-control" id="description" value="<?= $product["description"]; ?>" name="description" placeholder="Description">

                <?php if (isset($errors["img"])): ?>
                    <div class='alert alert-danger' role='alert'>
                        <?php echo $errors["img"]; ?>
                    </div>
                <?php endif; ?>
                <label for="img">Img</label>
                <input class="form-control" id="img" value="<?= $product["image"]; ?>" name="img" placeholder="Img">

                <?php if (isset($errors["stock"])): ?>
                    <div class='alert alert-danger' role='alert'>
                        <?php echo $errors["stock"]; ?>
                    </div>
                <?php endif; ?>
                <label for="stock">Stock</label>
                <input class="form-control" id="stock" value="<?= $product["stock"]; ?>" name="stock" placeholder="Stock">

                <?php if (isset($errors["category"])): ?>
                    <div class='alert alert-danger' role='alert'>
                        <?php echo $errors["category"]; ?>
                    </div>
                <?php endif; ?>
                <label for="category_id">Category ID</label>
                <input class="form-control" id="category_id" value="<?= $product["category_id"]; ?>" name="category_id" placeholder="Category ID">
            </div>
            <button type="submit" class="btn btn-primary">Edit item</button>
        </form>
</main>
<div style="margin-bottom: 30px"></div>
<?php include __DIR__ . '/../includes/footer.php'; ?>