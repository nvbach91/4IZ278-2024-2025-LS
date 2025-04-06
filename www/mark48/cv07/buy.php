<?php
require_once "classes/Good.php";
require_once "db/GoodDb.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Nebyl poskytnut parametr id.');
}

$productId = intval($_GET['id']);

$goodDb = new GoodDb();
$product = $goodDb->getById($productId);

if (!$product) {
    die('Produkt nebyl nalezen.');
}

$successMsg = "";
$errorMsg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["action"])) {
        if ($_POST["action"] === "delete") {
            // Delete product and redirect if successful
            if ($goodDb->delete($productId)) {
                header("Location: index.php?msg=Produkt+byl+smazán");
                exit;
            } else {
                $errorMsg = "Chyba při mazání produktu.";
            }
        }
    }
}

require_once 'head.php';
?>

<div class="container mt-5">
    <?php if ($successMsg): ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($successMsg) ?>
        </div>
    <?php endif; ?>
    <?php if ($errorMsg): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($errorMsg) ?>
        </div>
    <?php endif; ?>

    <h2><?= htmlspecialchars($product->name) ?></h2>
    <div class="row">
        <div class="col-md-6">
            <img src="<?= htmlspecialchars($product->img) ?>" alt="<?= htmlspecialchars($product->name) ?>" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h4>Cena: <?= htmlspecialchars($product->price) ?></h4>
            <p><?= htmlspecialchars($product->description) ?></p>
            <a href="purchase_confirm.php?id=<?= urlencode($product->good_id) ?>" class="btn btn-primary">Koupit nyní</a>
            <a href="index.php" class="btn btn-secondary">Zpět na produkty</a>
            <!-- Update Product Button -->
            <a href="edit-item.php?id=<?= urlencode($product->good_id) ?>" class="btn btn-warning">Upravit produkt</a>
        </div>
    </div>
    <hr>
    <h3>Smazat produkt</h3>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'] . "?id=" . urlencode($product->good_id)) ?>" method="post" onsubmit="return confirm('Opravdu chcete smazat tento produkt?');">
        <input type="hidden" name="action" value="delete">
        <button type="submit" class="btn btn-danger">Smazat produkt</button>
    </form>

</div>

<?php
require_once "footer.php";
?>