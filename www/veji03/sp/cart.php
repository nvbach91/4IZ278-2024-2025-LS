<?php
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/checkLogin.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$cart = $_SESSION['cart'];

$cartItems = [];
$totalPrice = 0;

if (isset($_GET['remove'])) {
    $removeId = (int) $_GET['remove'];
    if (isset($_SESSION['cart'][$removeId])) {
        unset($_SESSION['cart'][$removeId]);
        header("Location: cart.php");
        exit;
    }
}

foreach ($cart as $productId => $quantity) {
    $product = $productsDB->fetchProductById($productId);
    if ($product) {
        $product['quantity'] = $quantity;
        $product['total'] = $product['price'] * $quantity;
        $totalPrice += $product['total'];
        $cartItems[] = $product;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_qty'], $_POST['product_id'])) {
    $productId = (int)$_POST['product_id'];
    $newQty = max(1, (int)$_POST['update_qty']);

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = $newQty;
    }

    header("Location: cart.php");
    exit;
}
?>

<?php include __DIR__ . '/includes/head.php'; ?>
<?php include __DIR__ . '/includes/navbar.php'; ?>

<main class="container mt-4">
     <h1>Váš košík</h1>

    <?php if (empty($cartItems)): ?>
        <p>Košík je prázdný.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Název</th>
                    <th>Cena za kus</th>
                    <th>Množství</th>
                    <th>Celkem</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= number_format($item['price'], 2) ?> Kč</td>
                        <td>
                            <form method="POST" class="d-flex" style="gap: 5px;">
                                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                <input type="number" name="update_qty" value="<?= $item['quantity'] ?>" class="form-control form-control-sm" min="1" style="width: 70px;">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Uložit</button>
                            </form>
                        </td>
                        <td><?= number_format($item['total'], 2) ?> Kč</td>
                        <td>
                            <a href="cart.php?remove=<?= $item['id'] ?>" class="btn btn-sm btn-danger">Odebrat</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr class="table-info">
                    <td colspan="3" class="text-end"><strong>Celková cena:</strong></td>
                    <td colspan="2"><strong><?= number_format($totalPrice, 2) ?> Kč</strong></td>
                </tr>
            </tbody>
        </table>
        <a href="checkout.php" class="btn btn-success">Přejít k objednávce</a>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
