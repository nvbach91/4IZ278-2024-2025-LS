<?php require_once __DIR__.'/database/ProductsDB.php'; ?>
<?php require_once __DIR__.'/database/CategoriesDB.php'; ?>
<?php

$productsDB = new ProductsDB();
$isSetID = !empty($_GET['id']);
$categoriesDB = new CategoriesDB();
$categories = $categoriesDB->fetchAll([]);

if ($isSetID) {
    $product = $productsDB->fetchProductByID($_GET['id']);
    if (!$product) {
        header("Location: edit-items.php");
        exit;
    }

    
}

if (!empty($_POST)) {
    // Zpracování formuláře
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? '';
    $imgURL = $_POST['imgURL'] ?? '';
    $category = $_POST['category'] ?? '';

    if (!empty($name) && !empty($price)) {
        $productsDB->updateProduct($_POST['id'], $name, $price, $imgURL, $category);
        header('Location: edit-items.php');
        exit;
    } else {
        $error = "fill in all fields!";
    }
}

?>

<?php include __DIR__.'/includes/head.php'; ?>
<div class="container">
    <h1>Edit item</h1>

        <form class="form" method='POST' action="<?php echo$_SERVER['PHP_SELF'];?>">
            <input type="hidden" class="form-control" id="id" name="id" value="<?php echo htmlspecialchars($product['product_id']); ?>" required>
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="imgURL" class="form-label">Image URL:</label>
                <input type="text" class="form-control" id="imgURL" name="imgURL" value="<?php echo htmlspecialchars($product['img']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label" class="form-label">Category</label>
                <select name='category' class="form-select">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category['category_id']); ?>" <?php echo $product['category_id'] == $category['category_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($category['category_id']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
        <a class="btn btn-danger" href="/delete-item.php?id=<?php echo $product['product_id']; ?>" class="button">Delete item from database!</a>
</div>
<?php include __DIR__.'/includes/foot.php'; ?>