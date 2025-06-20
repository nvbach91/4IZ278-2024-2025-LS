<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../functions/php/gameHelpers.php';
require_once __DIR__ . '/layouts/head.php';

// Získání a validace produktu
list($product, $categoryNames, $errorMsg) = getGameDetail();
?>

<?php if ($errorMsg): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
    <?php require_once __DIR__ . '/layouts/footer.php'; exit; ?>
<?php endif; ?>

<div class="container mt-5 mb-5">
    <div class="row">
        <!-- Foto vlevo -->
        <div class="col-md-4 mb-4 d-flex align-items-center">
            <img src="/~adaj12/test/assets/img/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid shadow-sm product-img-detail">
        </div>
        <!-- Info vpravo -->
        <div class="col-md-8">
            <h2 class="mb-3"><?= htmlspecialchars($product['name']) ?></h2>
            <div class="mb-3">
                <strong>Popis produktu:</strong>
                <div><?= nl2br(htmlspecialchars($product['detail'])) ?></div>
            </div>
            <div class="row align-items-center mb-4">
                <div class="col-auto">
                    <div class="fs-4 fw-bold mb-2">
                        <?= number_format($product['price'], 2) ?> Kč
                    </div>
                </div>
                <div class="col-auto">
                    <?php if ((int)$product['stock'] > 0): ?>
                        <form method="post" action="/~adaj12/test/pages/products.php">
                            <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
                            <div class="input-group">
                                <input type="number" name="quantity" value="1" min="1" max="<?= (int)$product['stock'] ?>" class="form-control" style="max-width:90px;">
                                <button type="submit" class="btn btn-primary">Přidat do košíku</button>
                            </div>
                        </form>
                    <?php else: ?>
                        <span class="text-danger fw-bold ms-2">Není skladem</span>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Parametry -->
            <div class="p-3 bg-light rounded">
                <ul class="mb-0 product-params-list">
                    <li><strong>Žánr:</strong> <?= htmlspecialchars($product['tag'] ?? '-') ?></li>
                    <li><strong>Kategorie:</strong> <?= htmlspecialchars($categoryNames[$product['category_id']] ?? $product['category_id']) ?></li>
                    <li><strong>Věk:</strong> <?= (int)$product['min_age'] ?>+</li>
                    <li><strong>Počet na skladě:</strong> <?= (int)$product['stock'] ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
