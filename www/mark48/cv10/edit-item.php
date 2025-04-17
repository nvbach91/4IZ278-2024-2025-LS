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
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["action"])) {
        if ($_POST["action"] === "update") {
            // Načtení a ošetření vstupních dat
            $newName = trim($_POST["name"] ?? "");
            $newPrice = trim($_POST["price"] ?? "");
            $newDescription = trim($_POST["description"] ?? "");
            $newImg = trim($_POST["img"] ?? "");

            $product->name = $newName;
            $product->price = $newPrice;
            $product->description = $newDescription;
            $product->img = $newImg;

            if ($goodDb->update($product)) {
                $successMsg = "Produkt byl úspěšně aktualizován.";
                // Načteme aktualizovaná data
                $product = $goodDb->getById($productId);
            } else {
                $errorMsg = "Chyba při aktualizaci produktu.";
            }
        }
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
        <button type="submit" class="btn btn-success">Upravit produkt</button>
    </form>

    <hr>



    <a href="index.php" class="btn btn-secondary mt-3">Zpět na produkty</a>
</div>

<?php
require_once "footer.php";
?>