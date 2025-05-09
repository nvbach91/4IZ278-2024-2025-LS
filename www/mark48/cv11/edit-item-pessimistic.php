<?php
require_once "classes/Good.php";
require_once "db/GoodDb.php";
require_once 'auth.php';
require_once 'head.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

requirePrivilege(2);

$goodDb = new GoodDb();
$userId = $_SESSION['name'] ?? 'guest';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Nebyl poskytnut parametr id.');
}

$productId = intval($_GET['id']);
$lockAcquired = $goodDb->lockProduct($productId, $userId);
$product = $goodDb->getById($productId);
$successMsg = '';
$errorMsg = '';

// Kontrola, zda zámek selhal (např. produkt už upravuje někdo jiný)
if (!$lockAcquired && $product->locked_by !== $userId) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>Produkt je právě upravován uživatelem <strong>" . htmlspecialchars($product->locked_by) . "</strong>.</div>
          <a href='buy.php?id=" . urlencode($productId) . "' class='btn btn-secondary'>Zpět</a></div>";
    require_once 'footer.php';
    exit;
}

// Zpracování formuláře
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["action"] ?? '') === "update") {
    $product->name        = trim($_POST["name"]);
    $product->price       = trim($_POST["price"]);
    $product->description = trim($_POST["description"]);
    $product->img         = trim($_POST["img"]);

    if ($goodDb->update($product)) {
        $successMsg = "Produkt byl úspěšně aktualizován.";
        $goodDb->unlockProduct($productId, $userId);
        $product = $goodDb->getById($productId);
    } else {
        $errorMsg = "Chyba při aktualizaci produktu.";
    }
}
?>

<div class="container mt-5">
    <h2>Editace produktu (pesimisticky)</h2>

    <?php if ($successMsg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMsg) ?></div>
    <?php endif; ?>

    <?php if ($errorMsg): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="action" value="update">

        <div class="form-group">
            <label for="name">Název produktu</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product->name) ?>" required>
        </div>

        <div class="form-group">
            <label for="price">Cena</label>
            <input type="text" class="form-control" id="price" name="price" value="<?= htmlspecialchars($product->price) ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Popis</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($product->description) ?></textarea>
        </div>

        <div class="form-group">
            <label for="img">URL obrázku</label>
            <input type="text" class="form-control" id="img" name="img" value="<?= htmlspecialchars($product->img) ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Upravit produkt</button>
        <a href="detail.php?id=<?= urlencode($product->good_id) ?>" class="btn btn-secondary">Zrušit</a>
    </form>
</div>

<?php require_once "footer.php"; ?>