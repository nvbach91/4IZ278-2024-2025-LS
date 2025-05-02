<?php

session_start();

if ($_SESSION['privilege'] < '2') {
    header("Location: index.php");
    exit;
}

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

if(is_null($good["timestampP"]) || time() - $good["timestampP"] > 60){
    $goodsDB->setTimestamp($goodId, time(), $_SESSION['user_id']);
    $good = $goodsDB->fetchById($goodId);
}

else if($_SESSION["user_id"] !== $good["user_id"]){
    header("Location: error.php");
    exit;
}


?>

<?php include __DIR__ . '/includes/header.php'; ?>
<main class="container">
    <form action=<?php echo "savePessimistic.php" . "?id=" . $goodId ?> method="POST" class="form-register">
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