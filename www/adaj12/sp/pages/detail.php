<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/layouts/head.php';
require_once __DIR__ . '/../functions/php/userProfileHelpers.php';

$orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$userId = $_SESSION['user_id'] ?? null;

if (!$orderId || !$userId) {
    header('Location: user.php');
    exit;
}

$orders = getUserOrdersWithItems($userId);
$detail = null;
foreach ($orders as $o) {
    if ($o['id'] == $orderId) {
        $detail = $o;
        break;
    }
}

if (!$detail) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Objednávka nenalezena.</div></div>";
    require_once __DIR__ . '/layouts/footer.php';
    exit;
}

$items = $detail['items'];
$address = $detail['address'];
?>

<div class="container mt-5">
    <a href="user.php" class="btn btn-outline-secondary mb-4">&larr; Zpět na seznam objednávek</a>
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">
            <h6 class="fw-bold mb-2">Objednávka #<?= $detail['id'] ?></h6>
            <div class="mb-2">
                <span class="text-muted">Datum:</span>
                <?= date('d.m.Y H:i', strtotime($detail['date'])) ?>
            </div>
            <div class="mb-2">
                <span class="text-muted">Stav:</span>
                <span class="fw-semibold"><?= htmlspecialchars($detail['status']) ?></span>
            </div>
            <?php if ($address): ?>
            <div class="mb-2">
                <span class="text-muted">Dodací adresa:</span><br>
                <?= htmlspecialchars($address['name'] ?? '') ?><br>
                <?= htmlspecialchars($address['street'] ?? '') ?><br>
                <?= htmlspecialchars($address['city'] ?? '') ?>, <?= htmlspecialchars($address['postal_code'] ?? '') ?><br>
                Tel: <?= htmlspecialchars($address['phone'] ?? '') ?><br>
                E-mail: <?= htmlspecialchars($address['email'] ?? '') ?><br>
                <span class="text-muted">Doprava:</span> <?= htmlspecialchars($address['shipping_method'] ?? '-') ?><br>
                <span class="text-muted">Platba:</span> <?= htmlspecialchars($address['payment_method'] ?? '-') ?>
            </div>
            <?php endif; ?>
            <div class="mb-2">
                <span class="fw-bold">Položky:</span>
                <ul class="mb-0">
                    <?php foreach ($items as $item): ?>
                        <li>
                            <?= htmlspecialchars($item['product']['name'] ?? 'Neznámý produkt') ?> × <?= $item['quantity'] ?>
                            (<?= number_format($item['price'], 2, ',', ' ') ?> Kč/ks)
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="fw-bold mt-2">
                Celková cena:
                <?= number_format(array_sum(array_map(fn($it) => $it['price'] * $it['quantity'], $items)), 2, ',', ' ') ?> Kč
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>
