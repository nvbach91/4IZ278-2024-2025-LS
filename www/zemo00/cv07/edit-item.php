<?php

require __DIR__ . "/incl/head.php";

require_once __DIR__ . "/Database/GoodsDB.php";

$goodsDB = new GoodsDB();
$goodId = isset($_GET['good_id']) ? (int)$_GET['good_id'] : 0;
$success = '';
$error = '';

if ($goodId <= 0) {
    die('Invalid product ID.');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $img = trim($_POST['img'] ?? '');

    if ($name === '' || $price === '' || !is_numeric($price)) {
        $error = "Name and numeric price are required.";
    } else {
        $args = [
            'update' => 'name = :name, description = :description, price = :price, img = :img',
            'conditions' => ["good_id = :id"],
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'img' => $img,
            'id' => $goodId
        ];

        $goodsDB->update($args);
        header("Location: edit-item.php?good_id=$goodId&success=1");
        exit;
    }
}

// Fetch item for form
$args = [
    'columns' => ['*'],
    'conditions' => ["good_id = $goodId"]
];
$good = $goodsDB->fetch($args)[0] ?? null;

if (!$good) {
    die('Product not found.');
}

$success = isset($_GET['success']) ? 'Product updated successfully!' : '';
?>

<div class="form-container">
    <h2>Edit Item</h2>

    <?php if ($error): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php elseif ($success): ?>
        <p class="success-message"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label class="label" for="name">Name</label>
            <input class="input" type="text" name="name" id="name" value="<?php echo htmlspecialchars($good['name']); ?>">
        </div>

        <div class="form-group">
            <label class="label" for="price">Price (Kč)</label>
            <input class="input" type="text" name="price" id="price" value="<?php echo htmlspecialchars($good['price']); ?>">
        </div>

        <div class="form-group">
            <label class="label" for="description">Description</label>
            <textarea class="textarea" name="description" id="description"><?php echo htmlspecialchars($good['description']); ?></textarea>
        </div>

        <div class="form-group">
            <label class="label" for="img">Image URL</label>
            <input class="input" type="text" name="img" id="img" value="<?php echo htmlspecialchars($good['img']); ?>">
        </div>

        <button class="button" type="submit">Update</button>
    </form>
</div>

<?php

include __DIR__ . "/incl/foot.html";

?>