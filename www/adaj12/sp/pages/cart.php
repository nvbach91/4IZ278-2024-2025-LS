<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../functions/php/cartHelpers.php';
require_once __DIR__ . '/layouts/head.php';

list($items, $total) = getCartData();
?>

<div class="container mt-4">
    <h2>Košík</h2>
    <div id="cart-empty-info" class="alert alert-info" style="display: <?= empty($items) ? 'block' : 'none' ?>;">Košík je prázdný.</div>
    <?php if (!empty($items)): ?>
    <div class="table-responsive">
        <table class="table align-middle" id="cart-table">
            <thead>
                <tr>
                    <th>Název produktu</th>
                    <th>Popis produktu</th>
                    <th>Počet kusů</th>
                    <th>Cena za kus</th>
                    <th>Cena celkem</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr id="cart-row-<?= $item['id'] ?>">
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= htmlspecialchars($item['description']) ?></td>
                        <td>
                            <input type="number"
                                   name="quantity[<?= $item['id'] ?>]"
                                   value="<?= $item['qty'] ?>"
                                   min="1"
                                   class="form-control cart-qty-input"
                                   style="width: 70px;"
                                   data-id="<?= $item['id'] ?>">
                        </td>
                        <td><?= number_format($item['price'], 2, ',', ' ') ?> Kč</td>
                        <td id="subtotal-<?= $item['id'] ?>"><?= number_format($item['subtotal'], 2, ',', ' ') ?> Kč</td>
                        <td>
                            <button type="button"
                                    class="btn btn-danger btn-sm cart-remove-btn"
                                    data-id="<?= $item['id'] ?>">Odebrat</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="border rounded p-3">
                <strong>Celková cena:</strong>
                <span class="fs-5" id="cart-total"><?= number_format($total, 2, ',', ' ') ?> Kč</span>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <button type="button" class="btn btn-success btn-lg" id="order-btn">Zaplatit/objednat</button>
            <?php else: ?>
                <a href="checkout.php" class="btn btn-success btn-lg">Zaplatit/objednat</a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- MODÁLNÍ OKNO: Přihlášení nebo registrace -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Přihlášení nebo registrace</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
      </div>
      <div class="modal-body">
        Pro dokončení objednávky se nejprve <a href="/~adaj12/test/pages/login.php">přihlaste</a>
        nebo <a href="/~adaj12/test/pages/register.php">zaregistrujte</a>.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
      </div>
    </div>
  </div>
</div>

<script src="/~adaj12/test/functions/javascript/cartUpdate.js"></script>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>
