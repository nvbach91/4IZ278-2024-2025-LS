<?php include __DIR__.'/includes/head.php'; ?>
<?php require_once __DIR__.'/database/ProductsDB.php';?>
<?php require_once __DIR__.'/database/CategoriesDB.php';?>
<?php

$productsDB = new ProductsDB();
$categoriesDB = new CategoriesDB();
$categories = $categoriesDB->fetchAll([]);

if (!empty($_POST)) {
    // Zpracování formuláře
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? '';
    $imgURL = $_POST['imgURL'] ?? '';
    $category = $_POST['category'] ?? '';

    if (!empty($name) && !empty($price)) {
        $productsDB->addProduct($name, $price, $imgURL, $category);
        header('Location: edit-items.php');
        exit;
    } else {
        $error = "Vyplňte všechna povinná pole.";
    }
}

?>
<div class="container">
    <h1>Add item</h1>
        <form class="form" method='POST' action="<?php echo$_SERVER['PHP_SELF'];?>">
            <input type="hidden" class="form-control" id="id" name="id" required>
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name"required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="imgURL" class="form-label">Image URL:</label>
                <input type="text" class="form-control" id="imgURL" name="imgURL" required>
            </div>
            <div class="mb-3">
                <label class="form-label" class="form-label">Category</label>
                <select name='category' class="form-select">
                    <?php foreach ($categories as $category): ?>
                        <option><?php echo htmlspecialchars($category['category_id']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
</div>



<?php include __DIR__.'/includes/foot.php'; ?>