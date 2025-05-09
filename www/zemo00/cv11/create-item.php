<?php

include __DIR__ . "/incl/head.html";

require_once __DIR__ . "/utilities/auth_manager.php";

require_once __DIR__ . "/Database/GoodsDB.php";

$goodsDB = new GoodsDB();
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $img = trim($_POST['img'] ?? '');

    if ($name === '' || $price === '' || !is_numeric($price)) {
        $error = "Name and numeric price are required.";
    } else {
        $goodsDB->insert([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'img' => $img
        ]);
        $success = "Product created successfully!";
    }
}
?>



<div class="form-container">
    <h2>Create New Item</h2>

    <?php if ($error): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php elseif ($success): ?>
        <p class="success-message"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label class="label" for="name">Name</label>
            <input class="input" type="text" name="name" id="name">
        </div>

        <div class="form-group">
            <label class="label" for="price">Price (Kč)</label>
            <input class="input" type="text" name="price" id="price">
        </div>

        <div class="form-group">
            <label class="label" for="description">Description</label>
            <textarea class="textarea" name="description" id="description"></textarea>
        </div>

        <div class="form-group">
            <label class="label" for="img">Image URL</label>
            <input class="input" type="text" name="img" id="img">
        </div>

        <button class="button" type="submit">Create Item</button>
    </form>
</div>





<?php

include __DIR__ . "/incl/foot.html";

?>