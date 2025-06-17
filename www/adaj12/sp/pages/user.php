<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/layouts/head.php';
require_once __DIR__ . '/../functions/php/userProfileHelpers.php';

$isLoggedIn = isUserLoggedIn();
$userId = getLoggedInUserId();

// Načítání údajů z DB
$userData = $userId ? getCurrentUserData($userId) : [];

// Primární údaje o uživateli
$userName = $userData['name'] ?? ($_SESSION['user_name'] ?? '');
$userEmail = $userData['email'] ?? ($_SESSION['user_email'] ?? '');
$userAvatar = $userData['avatar'] ?? ($_SESSION['user_avatar'] ?? '');

// Dodací údaje z DB 
$shipping_name        = $userData['shipping_name']        ?? '';
$shipping_street      = $userData['shipping_street']      ?? '';
$shipping_postal_code = $userData['shipping_postal_code'] ?? '';
$shipping_city        = $userData['shipping_city']        ?? '';
$shipping_phone       = $userData['shipping_phone']       ?? '';

$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';
?>

<div class="container mt-5 profile-container">
<?php if ($isLoggedIn): ?>
    <div class="d-flex justify-content-end mb-3">
        <a href="../functions/php/logout.php" class="btn btn-outline-danger">Odhlásit se</a>
    </div>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="row">
        <!-- Avatar -->
        <div class="col-md-4 d-flex align-items-center justify-content-center profile-avatar-col">
            <div class="profile-avatar-box">
                <?php if ($userAvatar): ?>
                    <img src="<?= htmlspecialchars($userAvatar) ?>" alt="Avatar" class="profile-avatar-img">
                <?php else: ?>
                    <span>
                        <i class="bi bi-person-circle profile-avatar-icon"></i>
                    </span>
                <?php endif; ?>
            </div>
        </div>
        <!-- Info -->
        <div class="col-md-8">
            <div class="mb-3">
                <input type="text" class="form-control form-control-lg text-center fw-bold" value="<?= htmlspecialchars($userName) ?>" readonly placeholder="Jméno a příjmení">
            </div>
            <div class="mb-3">
                <input type="email" class="form-control form-control-lg text-center" value="<?= htmlspecialchars($userEmail) ?>" readonly placeholder="Email">
            </div>
            <!-- Úpravy profilu -->
            <div class="mb-3">
                <button class="btn btn-outline-secondary w-100" data-bs-toggle="modal" data-bs-target="#editProfileModal">Úpravy</button>
            </div>
            <!-- Změna hesla -->
            <div class="mb-3">
                <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Změnit heslo</button>
            </div>
            <!-- Zrušit účet -->
            <div>
                <button class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">Zrušit účet</button>
            </div>
        </div>
    </div>

    <!-- Historie objednávek -->
    <div class="mt-5">
        <div class="profile-orders-box">
            <h5 class="text-center text-muted mb-4">Aktivní objednávky a jejich historie</h5>
            <?php
            $userOrders = $userId ? getUserOrdersWithItems($userId) : [];

            if (!empty($userOrders)):
                foreach ($userOrders as $order):
                    $items = $order['items'];
                    $address = $order['address'];
                    ?>
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="fw-bold mb-2">Objednávka #<?= $order['id'] ?></h6>
                            <div class="mb-2">
                                <span class="text-muted">Datum:</span>
                                <?= date('d.m.Y H:i', strtotime($order['date'])) ?>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted">Stav:</span>
                                <span class="fw-semibold"><?= htmlspecialchars($order['status']) ?></span>
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
                <?php endforeach;
            else: ?>
                <div class="alert alert-secondary text-center">
                    Nemáte žádné objednávky.
                </div>
            <?php endif; ?>
        </div>
    </div>

<!-- MODAL: Úprava profilu -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="../functions/php/userChange.php" enctype="multipart/form-data" novalidate>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editProfileModalLabel">Úprava profilu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="action" value="update_profile">
          <div class="mb-3">
            <label for="name" class="form-label">Jméno a příjmení</label>
            <input type="text" class="form-control" id="name" name="name"
                   pattern=".{3,}" title="Zadejte jméno (alespoň 3 znaky)." value="<?= htmlspecialchars($userName) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Změnit avatar</label>
            <div class="d-flex flex-wrap gap-3">
                <?php
                $avatarFiles = [
                    '/~adaj12/test/assets/avatars/girl1.png',
                    '/~adaj12/test/assets/avatars/girl2.png',
                    '/~adaj12/test/assets/avatars/girl3.png',
                    '/~adaj12/test/assets/avatars/man1.png',
                    '/~adaj12/test/assets/avatars/man2.png',
                    '/~adaj12/test/assets/avatars/man3.png'
                ];
                foreach ($avatarFiles as $avatar):
                    $isSelected = ($userAvatar === $avatar);
                ?>
                    <label class="avatar-radio-label">
                        <input type="radio" name="selected_avatar" value="<?= $avatar ?>" <?= $isSelected ? 'checked' : '' ?> style="display:none;">
                        <img src="<?= $avatar ?>" alt="avatar"
                             class="avatar-radio-img<?= $isSelected ? ' selected' : '' ?>">
                    </label>
                <?php endforeach; ?>
            </div>
            <div class="form-text">Vyberte si svůj avatar.</div>
          </div>
          <!-- Dodací údaje -->
          <h5 class="mb-3 mt-4">Dodací údaje (nepovinné)</h5>
          <div class="mb-3">
              <label for="shipping_name" class="form-label">Jméno a příjmení (pro doručení)</label>
              <input type="text" class="form-control" id="shipping_name" name="shipping_name"
                pattern=".{3,}" title="Zadejte jméno a příjmení (alespoň 3 znaky)."
                value="<?= htmlspecialchars($shipping_name) ?>">
          </div>
          <div class="mb-3">
              <label for="shipping_street" class="form-label">Ulice a číslo popisné</label>
              <input type="text" class="form-control" id="shipping_street" name="shipping_street"
                pattern=".{3,}" title="Zadejte ulici a číslo popisné (alespoň 3 znaky)."
                value="<?= htmlspecialchars($shipping_street) ?>">
          </div>
          <div class="mb-3">
              <label for="shipping_postal_code" class="form-label">PSČ</label>
              <input type="text" class="form-control" id="shipping_postal_code" name="shipping_postal_code"
                pattern="^\d{3}\s?\d{2}$" title="Zadejte platné PSČ (např. 11000 nebo 110 00)"
                value="<?= htmlspecialchars($shipping_postal_code) ?>">
          </div>
          <div class="mb-3">
              <label for="shipping_city" class="form-label">Město</label>
              <input type="text" class="form-control" id="shipping_city" name="shipping_city"
                pattern=".{2,}" title="Zadejte město (alespoň 2 znaky)."
                value="<?= htmlspecialchars($shipping_city) ?>">
          </div>
          <div class="mb-3">
              <label for="shipping_phone" class="form-label">Telefon</label>
              <input type="tel" class="form-control" id="shipping_phone" name="shipping_phone"
                pattern="^\d{9}$" title="Zadejte telefon ve tvaru 123456789 (9 číslic bez mezer)"
                value="<?= htmlspecialchars($shipping_phone) ?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zrušit</button>
          <button type="submit" class="btn btn-primary">Uložit změny</button>
        </div>
      </div>
    </form>
  </div>
</div>

    <!-- MODAL: Změna hesla -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="post" action="../functions/php/userChange.php">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="changePasswordModalLabel">Změna hesla</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="action" value="change_password">
              <div class="mb-3">
                <label for="old_password" class="form-label">Staré heslo</label>
                <input type="password" class="form-control" id="old_password" name="old_password" required>
              </div>
              <div class="mb-3">
                <label for="new_password" class="form-label">Nové heslo</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
              </div>
              <div class="mb-3">
                <label for="new_password2" class="form-label">Nové heslo znovu</label>
                <input type="password" class="form-control" id="new_password2" name="new_password2" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zrušit</button>
              <button type="submit" class="btn btn-primary">Změnit heslo</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- MODAL: Smazat účet -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="post" action="../functions/php/userChange.php">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">Zrušení účtu</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="action" value="delete_account">
              <p>Opravdu si přejete zrušit svůj účet? Tato akce je nevratná.</p>
              <p><small>Pro potvrzení akce zadejte své heslo:</small></p>
              <input type="password" class="form-control" name="confirm_password" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zrušit</button>
              <button type="submit" class="btn btn-danger">Zrušit účet</button>
            </div>
          </div>
        </form>
      </div>
    </div>

<?php else: ?>
    <div class="alert alert-warning text-center mt-5">
        Pro zobrazení profilu se musíte <a href="login.php" class="alert-link">přihlásit</a> nebo <a href="register.php" class="alert-link">registrovat</a>.
        <div class="mt-3">
            <a href="login.php" class="btn btn-primary me-2">Přihlásit se</a>
            <a href="register.php" class="btn btn-outline-primary">Registrovat</a>
        </div>
    </div>
<?php endif; ?>
</div>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
