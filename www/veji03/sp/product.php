<?php
require_once __DIR__ . '/includes/init.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$product = $productsDB->fetchProductById($_GET['id']);

if (!$product) {
    header('Location: index.php');
    exit;
}

$productId = (int)$_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user'])) {
        $_SESSION['redirect_after_login'] = [
            'url' => "product.php?id=$productId",
            'add_to_cart' => true,
            'product_id' => $productId,
            'quantity' => isset($_POST['quantity']) ? max(1, (int)$_POST['quantity']) : 1
        ];
        header("Location: login.php");
        exit;
    }

    $quantity = isset($_POST['quantity']) ? max(1, (int)$_POST['quantity']) : 1;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }

    header("Location: cart.php");
    exit;
}

?>

<?php include __DIR__ . '/includes/head.php'; ?>
<?php include __DIR__ . '/includes/navbar.php'; ?>

<main class="container mt-4">
    <div class="row">
        <div class="col-md-5">
            <img src="images/<?= htmlspecialchars($product['image']) ?>" class="img-fluid" alt="<?= htmlspecialchars($product['name']) ?>">
        </div>
        <div class="col-md-7">
            <h2><?= htmlspecialchars($product['name']) ?></h2>
            <p><strong>Značka:</strong> <?= htmlspecialchars($product['brand_name']) ?></p>
            <p><strong>Cena:</strong> <?= number_format($product['price'], 0, ',', ' ') ?> Kč</p>
            <p><strong>Displej:</strong> <?= htmlspecialchars($product['display_size']) ?>"</p>
            <p><strong>RAM:</strong> <?= htmlspecialchars($product['ram']) ?> GB</p>
            <p><strong>Baterie:</strong> <?= htmlspecialchars($product['battery_capacity']) ?> mAh</p>
            <p><strong>Rok vydání:</strong> <?= htmlspecialchars($product['release_year']) ?></p>
            <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>

            <form method="post">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <div class="mb-3">
                    <label for="quantity" class="form-label">Počet kusů</label>
                    <input type="number" class="form-control" name="quantity" id="quantity" value="1" min="1" required>
                </div>
                <button type="submit" class="btn btn-success">Přidat do košíku</button>
            </form>
        </div>
    </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
