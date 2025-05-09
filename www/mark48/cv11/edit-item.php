<?php
require_once "classes/Good.php";
require_once "db/GoodDb.php";


require_once 'auth.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// jen manažeři a admini
requirePrivilege(2);


// Kontrola, zda byl předán parametr id
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

// Zpracování formuláře
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["action"] ?? '') === "update") {
    // Načteme starý timestamp z POSTu
    $postedTs = trim($_POST['timestamp'] ?? '');

    // Ošetření vstupů
    $product->name        = trim($_POST["name"]);
    $product->price       = trim($_POST["price"]);
    $product->description = trim($_POST["description"]);
    $product->img         = trim($_POST["img"]);
    $product->timestamp = $postedTs;

    if ($goodDb->update($product)) {
        $successMsg = "Produkt byl úspěšně aktualizován.";
        // Znovu načteme, teď s novým timestampem
        $product = $goodDb->getById($productId);
    } else {
        $errorMsg = "Konflikt: mezitím někdo produkt změnil. Zobrazují se aktuální údaje.";
        // Načteme čerstvá data, aby uživatel viděl nové hodnoty a timestamp
        $product = $goodDb->getById($productId);
    }
}



require_once 'head.php';
?>

<div class="container mt-5">
    <h2>Editace produktu</h2>

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

    <!-- Formulář pro úpravu produktu -->
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'] . "?id=" . urlencode($product->good_id)) ?>" method="post">
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
        <input type="hidden" name="timestamp" value="<?= htmlspecialchars($product->timestamp) ?>">

        <button type="submit" class="btn btn-success">Upravit produkt optimisticky</button>
    </form>

    <hr>



    <a href="index.php" class="btn btn-secondary mt-3">Zpět na produkty</a>
</div>

<?php
require_once "footer.php";
?>