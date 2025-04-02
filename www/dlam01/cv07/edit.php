<?php
require_once __DIR__ . '/database/GoodsDB.php';
$goodsDB = new GoodsDB();

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}
$goodId = $_GET["id"];
$good = $goodsDB->fetchById($goodId);
if (!$good) {
    header("Location: index.php");
    exit;
}

if (!empty($_POST)) {
    $name = htmlspecialchars(trim($_POST["name"]));
    $price = htmlspecialchars(trim($_POST["price"]));
    $description = htmlspecialchars(trim($_POST["description"]));
    $img = htmlspecialchars(trim($_POST["img"]));

    if (empty($name)) {
        $errors["name"] = "Name is required";
    }

    if (empty($price)) {
        $errors["price"] = "Price is required";
    }

    if (empty($description)) {
        $errors["description"] = "Description is required";
    }

    if (!filter_var($img, FILTER_VALIDATE_URL)) {
        $errors["img"] = "Link to image is required";
    }

    if (empty($errors)) {
        $goodsDB->update($goodId, $name, $price, $description, $img);
        header("Location: index.php");
    }
}
?>

<?php include __DIR__ . '/includes/header.php'; ?>
<main class="container">
    <form action=<?php echo $_SERVER['PHP_SELF'] . "?id=" . $goodId ?> method="POST" class="form-register">
        <h1>Edit</h1>
        <form method="POST">
            <div class="form-group">
                <?php if (isset($errors["name"])): ?>
                    <div class='alert alert-danger' role='alert'>
                        <?php echo $errors["name"]; ?>
                    </div>
                <?php endif; ?>
                <label for="name">Name</label>
                <input class="form-control" id="name" value=<?= $good["name"]; ?> name="name" placeholder="Name">

                <?php if (isset($errors["price"])): ?>
                    <div class='alert alert-danger' role='alert'>
                        <?php echo $errors["price"]; ?>
                    </div>
                <?php endif; ?>
                <label for="price">Price</label>
                <input class="form-control" id="price" value=<?= $good["price"]; ?> name="price" placeholder="Price">

                <?php if (isset($errors["description"])): ?>
                    <div class='alert alert-danger' role='alert'>
                        <?php echo $errors["description"]; ?>
                    </div>
                <?php endif; ?>
                <label for="description">Description</label>
                <?= $good["description"]; ?>
                <input class="form-control" id="description" value=<?= $good["description"]; ?> name="description" placeholder="Description">

                <?php if (isset($errors["img"])): ?>
                    <div class='alert alert-danger' role='alert'>
                        <?php echo $errors["img"]; ?>
                    </div>
                <?php endif; ?>
                <label for="img">Img</label>
                <input class="form-control" id="img" value=<?= $good["img"]; ?> name="img" placeholder="Img">
            </div>
            <button type="submit" class="btn btn-primary">Edit item</button>
        </form>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>