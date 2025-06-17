<?php
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/checkLogin.php';

$cart = $_SESSION['cart'] ?? [];
$userId = $_SESSION['user']['id'] ?? null;

if (empty($cart)) {
    header('Location: cart.php');
    exit;
}

$products = [];
$total = 0;

foreach ($cart as $productId => $quantity) {
    $product = $productsDB->fetchProductById($productId);
    if ($product) {
        $product['quantity'] = $quantity;
        $product['total'] = $product['price'] * $quantity;
        $products[] = $product;
        $total += $product['total'];
    }
}

$pdo = (new Database())->getConnection();
$stmt = $pdo->prepare("SELECT street, city, zip, country FROM users WHERE id = ?");
$stmt->execute([$userId]);
$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
$defaultStreet = $userInfo['street'] ?? '';
$defaultCity = $userInfo['city'] ?? '';
$defaultZip = $userInfo['zip'] ?? '';
$defaultCountry = $userInfo['country'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $street = trim($_POST['street'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $zip = trim($_POST['zip'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $note = $_POST['note'] ?? '';
    $payment = $_POST['payment'] ?? 'dobírka';

    if ($street && $city && $zip && $country) {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO orders (user_id, created_at, street, city, zip, country, payment_method, note) VALUES (?, NOW(), ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $street, $city, $zip, $country, $payment, $note]);
        $orderId = $pdo->lastInsertId();

        $itemStmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($products as $product) {
            $itemStmt->execute([
                $orderId,
                $product['id'],
                $product['quantity'],
                $product['price']
            ]);
        }

        $pdo->commit();
        unset($_SESSION['cart']);
        header('Location: profile.php?success=1');
        exit;
    }
}
?>

<?php include __DIR__ . '/includes/head.php'; ?>
<?php include __DIR__ . '/includes/navbar.php'; ?>

<main class="container mt-4">
    <h2>Dokončení objednávky</h2>

    <form method="POST" class="row">
        <div class="col-md-6">
            <h5>Doručovací údaje</h5>
            <div class="mb-3">
                <label for="street" class="form-label">Ulice a číslo</label>
                <input type="text" class="form-control" id="street" name="street" value="<?= htmlspecialchars($defaultStreet) ?>" required>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">Město</label>
                <input type="text" class="form-control" id="city" name="city" value="<?= htmlspecialchars($defaultCity) ?>" required>
            </div>
            <div class="mb-3">
                <label for="zip" class="form-label">PSČ</label>
                <input type="text" class="form-control" id="zip" name="zip" value="<?= htmlspecialchars($defaultZip) ?>" required>
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Země</label>
                <input type="text" class="form-control" id="country" name="country" value="<?= htmlspecialchars($defaultCountry) ?>" required>
            </div>
            <div class="mb-3">
                <label for="payment" class="form-label">Způsob platby</label>
                <select class="form-select" id="payment" name="payment">
                    <option value="dobírka">Dobírka</option>
                    <option value="kartou">Kartou online</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Poznámka k objednávce</label>
                <textarea class="form-control" id="note" name="note"></textarea>
            </div>
        </div>

        <div class="col-md-6">
            <h5>Souhrn objednávky</h5>
            <ul class="list-group mb-3">
                <?php foreach ($products as $product): ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <?= htmlspecialchars($product['name']) ?> x <?= $product['quantity'] ?>
                        <span><?= number_format($product['total'], 0, ',', ' ') ?> Kč</span>
                    </li>
                <?php endforeach; ?>
                <li class="list-group-item d-flex justify-content-between fw-bold">
                    Celkem:
                    <span><?= number_format($total, 0, ',', ' ') ?> Kč</span>
                </li>
            </ul>
            <button type="submit" class="btn btn-success w-100">Odeslat objednávku</button>
        </div>
    </form>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
