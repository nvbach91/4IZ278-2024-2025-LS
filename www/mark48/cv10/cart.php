<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Pokud uživatel není přihlášen, přesměrujeme ho na login stránku
if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit;
}

// Zpracování požadavku na odstranění produktu z košíku
if (isset($_GET['remove'])) {
    $removeId = intval($_GET['remove']);
    if (isset($_SESSION['cart'])) {
        // Vyhledáme a odstraníme produkt z pole košíku
        $index = array_search($removeId, $_SESSION['cart']);
        if ($index !== false) {
            unset($_SESSION['cart'][$index]);
            // Pro reindexaci pole (volitelné)
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }
    // Po odstranění přesměrujeme uživatele zpět na stránku košíku
    header("Location: cart.php");
    exit;
}

require_once 'db/GoodDb.php';
require_once 'classes/Good.php';

$goodDb = new GoodDb();

// Pokud v session není košík nebo je prázdný, nastavíme prázdné pole
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <title>Váš košík</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Váš košík</h2>
        <?php if (empty($cartItems)): ?>
            <p>Váš košík je prázdný.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($cartItems as $id): ?>
                    <?php
                    $product = $goodDb->getById($id);
                    if (!$product) {
                        continue;
                    }
                    ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <a href="buy.php?id=<?= urlencode($product->good_id) ?>">
                                <img class="card-img-top" src="<?= htmlspecialchars($product->img) ?>" alt="<?= htmlspecialchars($product->name) ?>" />
                            </a>
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="buy.php?id=<?= urlencode($product->good_id) ?>">
                                        <?= htmlspecialchars($product->name) ?>
                                    </a>
                                </h4>
                                <h5><?= htmlspecialchars($product->price) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($product->description) ?></p>
                                <!-- Tlačítko pro odstranění zboží z košíku -->
                                <a href="cart.php?remove=<?= urlencode($product->good_id) ?>" class="btn btn-danger">Odstranit</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <a href="index.php" class="btn btn-secondary">Pokračovat v nakupování</a>
    </div>
</body>

</html>