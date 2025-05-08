<?php

include __DIR__ . "/incl/head.html";

require_once __DIR__ . "/utilities/auth_manager.php";

require_once __DIR__ . "/Database/GoodsDB.php";

$goodsDB = new GoodsDB();
$goodId = isset($_GET['good_id']) ? (int)$_GET['good_id'] : 0;
$success = '';
$error = '';

if ($goodId <= 0) {
    die('Invalid product ID.');
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if($_GET['method'] == 'optimistic'){
        require __DIR__ . "/utilities/optimistic.php";
    } elseif($_GET['method'] == 'pessimistic'){
        require __DIR__ . "/utilities/pessimistic.php";
    } else {
        die("Invalid locking method!");
    }

}

$args = [
    'columns' => ['*'],
    'conditions' => ["good_id = $goodId"]
];
$good = $goodsDB->fetch($args)[0] ?? null;

if (!$good) {
    die('Product not found.');
}

if($_GET['method'] == 'pessimistic'){
    require __DIR__ . "/utilities/pessimistic_lock.php";
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
    <?php if (isset($_SESSION['fail'])): ?>
        <strong>Name: </strong><p><?php echo $_POST['name']; ?></p>
        <strong>Price: </strong><p><?php echo $_POST['price']; ?></p>
        <strong>Description: </strong><p><?php echo $_POST['description']; ?></p>
        <strong>Img: </strong><p><?php echo $_POST['img']; ?></p>
        <hr style="border: 1px solid red;">
    <?php
        unset($_SESSION['fail']);
        endif;
    ?>

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

        <input type="hidden" name="last_updated" value="<?php echo htmlspecialchars($good['last_updated']); ?>">

        <button class="button" type="submit">Update</button>
    </form>
</div>

<?php

include __DIR__ . "/incl/foot.html";

?>