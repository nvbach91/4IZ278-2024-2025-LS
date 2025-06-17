<?php
require_once __DIR__ . '/../functions/php/adminOrdersHelpers.php';
require_once __DIR__ . '/../pages/layouts/admin-head.php';
?>
<link rel="stylesheet" href="/~adaj12/test/assets/css/admin-orders.css">

<div class="container my-5">
    <h2 class="mb-4">Objednávky</h2>
    <?php if (isset($_GET['edit'])): ?>
        <div class="alert alert-success">Změna byla uložena.</div>
    <?php endif; ?>
    <table class="table table-bordered table-hover bg-white">
        <thead>
            <tr>
                <th>ID</th>
                <th>Datum</th>
                <th>Uživatel</th>
                <th>Stav</th>
                <th>Dodací adresa</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order): ?>
            <?php
            $address = [
                'name' => '',
                'street' => '',
                'city' => '',
                'postal_code' => '',
                'email' => '',
                'phone' => ''
            ];
            if (!empty($order['shipping_address'])) {
                $decoded = json_decode($order['shipping_address'], true);
                if (is_array($decoded)) {
                    $address['name'] = $decoded['name'] ?? '';
                    $address['street'] = $decoded['street'] ?? '';
                    $address['city'] = $decoded['city'] ?? '';
                    $address['postal_code'] = $decoded['postal_code'] ?? '';
                    $address['email'] = $decoded['email'] ?? '';
                    $address['phone'] = $decoded['phone'] ?? '';
                }
            }
            ?>
            <tr>
                <form method="post" class="status-form">
                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                    <td><?= $order['id'] ?></td>
                    <td><?= htmlspecialchars($order['date'] ?? '') ?></td>
                    <td><?= htmlspecialchars($order['user_name'] ?? '-') ?></td>
                    <td>
                        <select name="status" class="form-select form-select-sm">
                            <option value="nová" <?= ($order['status'] ?? '') === 'nová' ? 'selected' : '' ?>>Nová</option>
                            <option value="zpracovává se" <?= ($order['status'] ?? '') === 'zpracovává se' ? 'selected' : '' ?>>Zpracovává se</option>
                            <option value="dodáno" <?= ($order['status'] ?? '') === 'dodáno' ? 'selected' : '' ?>>Dodáno</option>
                            <option value="zrušeno" <?= ($order['status'] ?? '') === 'zrušeno' ? 'selected' : '' ?>>Zrušeno</option>
                        </select>
                    </td>
                    <td>
                        <?= htmlspecialchars($address['name']) ?><br>
                        <?= htmlspecialchars($address['street']) ?><br>
                        <?= htmlspecialchars($address['city']) ?> <?= htmlspecialchars($address['postal_code']) ?><br>
                        <small><?= htmlspecialchars($address['email']) ?> <?= htmlspecialchars($address['phone']) ?></small>
                    </td>
                    <td>
                        <button type="button"
                            class="btn btn-outline-primary btn-sm open-address-modal"
                            data-bs-toggle="modal"
                            data-bs-target="#addressModal"
                            data-order-id="<?= $order['id'] ?>"
                            data-shipping-name="<?= htmlspecialchars($address['name'], ENT_QUOTES) ?>"
                            data-shipping-street="<?= htmlspecialchars($address['street'], ENT_QUOTES) ?>"
                            data-shipping-city="<?= htmlspecialchars($address['city'], ENT_QUOTES) ?>"
                            data-shipping-postal_code="<?= htmlspecialchars($address['postal_code'], ENT_QUOTES) ?>"
                            data-shipping-email="<?= htmlspecialchars($address['email'], ENT_QUOTES) ?>"
                            data-shipping-phone="<?= htmlspecialchars($address['phone'], ENT_QUOTES) ?>"
                        >Upravit adresu</button>
                        <button type="submit" class="btn btn-primary btn-sm ms-2">Uložit stav</button>
                    </td>
                </form>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal pro úpravu adresy -->
<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="../functions/php/orders-edit-address.php" class="modal-content" id="modalAddressForm">
      <div class="modal-header">
        <h5 class="modal-title" id="addressModalLabel">Upravit dodací adresu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="order_id" id="modal_order_id">
        <div class="mb-2">
            <label class="form-label">Jméno a příjmení</label>
            <input type="text" class="form-control" name="shipping_name" id="modal_shipping_name" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Ulice</label>
            <input type="text" class="form-control" name="shipping_street" id="modal_shipping_street" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Město</label>
            <input type="text" class="form-control" name="shipping_city" id="modal_shipping_city" required>
        </div>
        <div class="mb-2">
            <label class="form-label">PSČ</label>
            <input type="text" class="form-control" name="shipping_postal_code" id="modal_shipping_postal_code" required>
        </div>
        <div class="mb-2">
            <label class="form-label">E-mail</label>
            <input type="email" class="form-control" name="shipping_email" id="modal_shipping_email" disabled>
        </div>
        <div class="mb-2">
            <label class="form-label">Telefon</label>
            <input type="text" class="form-control" name="shipping_phone" id="modal_shipping_phone" disabled>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Uložit adresu</button>
      </div>
    </form>
  </div>
</div>

<script src="/~adaj12/test/functions/javascript/admin-orders-modal.js"></script>
<?php require_once __DIR__ . '/../pages/layouts/admin-footer.php'; ?>
