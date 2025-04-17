<?php
require_once 'auth.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "classes/Good.php";
require_once "db/GoodDb.php";

// Načtení produktu (bez omezení zobrazení)
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Nebyl poskytnut parametr id.');
}

$productId = intval($_GET['id']);
$goodDb    = new GoodDb();
$product   = $goodDb->getById($productId);

if (!$product) {
    die('Produkt nebyl nalezen.');
}

$errorMsg = '';
if ($_SERVER["REQUEST_METHOD"] === "POST" && $_SESSION['privilege'] >= 2) {
    if (isset($_POST["action"]) && $_POST["action"] === "delete") {
        if ($goodDb->delete($productId)) {
            header("Location: index.php?msg=Produkt+byl+smazán");
            exit;
        } else {
            $errorMsg = "Chyba při mazání produktu.";
        }
    }
}

require_once 'head.php';
?>

<div class="container mt-5">
    <?php if ($errorMsg): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
    <?php endif; ?>

    <h2><?= htmlspecialchars($product->name) ?></h2>
    <div class="row">
        <div class="col-md-6">
            <img src="<?= htmlspecialchars($product->img) ?>"
                alt="<?= htmlspecialchars($product->name) ?>"
                class="img-fluid">
        </div>
        <div class="col-md-6">
            <h4>Cena: <?= htmlspecialchars($product->price) ?></h4>
            <p><?= htmlspecialchars($product->description) ?></p>

            <a href="purchase_confirm.php?id=<?= urlencode($product->good_id) ?>"
                class="btn btn-primary">Koupit nyní</a>
            <a href="index.php" class="btn btn-secondary">Zpět na produkty</a>

            <?php if (isset($_SESSION['privilege']) && $_SESSION['privilege'] >= 2): ?>
                <!-- Tlačítko pro úpravu -->
                <a href="edit-item.php?id=<?= urlencode($product->good_id) ?>"
                    class="btn btn-warning">Upravit produkt</a>
            <?php endif; ?>
        </div>
    </div>

    <?php if (isset($_SESSION['privilege']) && $_SESSION['privilege'] >= 2): ?>
        <hr>
        <h3>Smazat produkt</h3>
        <form method="post"
            onsubmit="return confirm('Opravdu chcete smazat tento produkt?');">
            <input type="hidden" name="action" value="delete">
            <button type="submit" class="btn btn-danger">Smazat produkt</button>
        </form>
    <?php endif; ?>
</div>

<?php require_once "footer.php"; ?>