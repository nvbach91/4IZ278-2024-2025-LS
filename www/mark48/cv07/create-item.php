<?php
require_once "classes/Good.php";
require_once "db/GoodDb.php";

$goodDb = new GoodDb();

$successMsg = "";
$errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Načtení a ošetření vstupních dat
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $img = trim($_POST['img'] ?? '');

    // Jednoduchá validace - všechna pole jsou povinná
    if (empty($name) || empty($price) || empty($description) || empty($img)) {
        $errorMsg = "Všechna pole jsou povinná.";
    } else {
        // Vytvoření nové instance třídy Good
        // Předpokládáme, že ID bude generováno automaticky, proto předáváme null
        $newGood = new Good(null, $name, $price, $description, $img);

        $newId = $goodDb->create($newGood);
        if ($newId !== false) {
            $successMsg = "Produkt byl úspěšně vytvořen s ID: " . $newId;
            // Přesměrujeme uživatele zpět na hlavní stránku s potvrzením
            header("Location: index.php?msg=Produkt+byl+vytvořen");
            exit;
        } else {
            $errorMsg = "Chyba při vytváření produktu.";
        }
    }
}

require_once 'head.php';
?>

<div class="container mt-5">
    <h2>Přidat nový produkt</h2>

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

    <form action="create-item.php" method="post">
        <div class="form-group">
            <label for="name">Název produktu</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Zadejte název produktu" required>
        </div>
        <div class="form-group">
            <label for="price">Cena</label>
            <input type="text" class="form-control" id="price" name="price" placeholder="Zadejte cenu produktu" required>
        </div>
        <div class="form-group">
            <label for="description">Popis</label>
            <textarea class="form-control" id="description" name="description" placeholder="Zadejte popis produktu" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="img">URL obrázku</label>
            <input type="text" class="form-control" id="img" name="img" placeholder="Zadejte URL obrázku" required>
        </div>
        <button type="submit" class="btn btn-success">Přidat produkt</button>
        <a href="index.php" class="btn btn-secondary">Zpět</a>
    </form>
</div>

<?php
require_once "footer.php";
?>