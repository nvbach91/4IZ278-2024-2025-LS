<?php
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/checkLogin.php';

$successMessage = '';
$errors = [];

if (isset($_GET['success']) && $_GET['success'] == '1') {
    $successMessage = 'Objednávka byla vytvořena.';
}

$userId = $_SESSION['user']['id'];
$user = $userDB->getUserById($userId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['change_password'])) {
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($password !== '') {
            if (strlen($password) < 6) {
                $errors[] = "Heslo musí mít alespoň 6 znaků.";
            } elseif ($password !== $confirmPassword) {
                $errors[] = "Hesla se neshodují.";
            } else {
                $userDB->updateUser($userId, $user['street'], $user['city'], $user['zip'], $user['country'], $password);
                $successMessage = "Heslo bylo změněno.";
            }
        } else {
            $errors[] = "Zadejte nové heslo.";
        }
    }

    if (isset($_POST['change_address'])) {
        $street = trim($_POST['street'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $zip = trim($_POST['zip'] ?? '');
        $country = trim($_POST['country'] ?? '');

        if ($street === '' || $city === '' || $zip === '' || $country === '') {
            $errors[] = "Všechna pole adresy jsou povinná.";
        } else {
            $userDB->updateUser($userId, $street, $city, $zip, $country, null);
            $user['street'] = $street;
            $user['city'] = $city;
            $user['zip'] = $zip;
            $user['country'] = $country;
            $successMessage = "Adresa byla změněna.";
        }
    }
}

$orders = $orderDB->getOrdersByUser($userId);
?>

<?php include __DIR__ . '/includes/head.php'; ?>
<?php include __DIR__ . '/includes/navbar.php'; ?>

<main class="container mt-5">
    <h2>Můj profil</h2>

    <?php renderMessages($successMessage, $errors);?>

    <section class="mb-4">
        <h5>Údaje o uživateli</h5>
        <div class="row">
            <form method="post" class="g-3 col-md-6">
                <div class="col-md-8">    
                    <div class="col-md-12">
                        <label class="form-label">Jméno a příjmení</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>" disabled>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">E-mail</label>
                        <input type="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                    </div>
                    <div class="col-md-12">
                        <label for="password" class="form-label">Nové heslo</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label for="confirm_password" class="form-label">Potvrzení hesla</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" name="change_password" class="btn btn-primary">Uložit heslo</button>
                </div>
            </form>
            <form method="post" class="g-3 col-md-6">
                <div class="col-md-8">
                    <div class="col-md-12">
                        <label for="street" class="form-label">Ulice a číslo</label>
                        <input type="text" name="street" id="street" class="form-control" value="<?= htmlspecialchars($user['street'] ?? '') ?>">
                    </div>
                    <div class="col-md-12">
                        <label for="city" class="form-label">Město</label>
                        <input type="text" name="city" id="city" class="form-control" value="<?= htmlspecialchars($user['city'] ?? '') ?>">
                    </div>
                    <div class="col-md-12">
                        <label for="zip" class="form-label">PSČ</label>
                        <input type="text" name="zip" id="zip" class="form-control" value="<?= htmlspecialchars($user['zip'] ?? '') ?>">
                    </div>
                    <div class="col-md-12">
                        <label for="country" class="form-label">Země</label>
                        <input type="text" name="country" id="country" class="form-control" value="<?= htmlspecialchars($user['country'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" name="change_address" class="btn btn-primary">Uložit adresu</button>
                </div>
            </form>
        </div>
    </section>

    <section>
        <h5>Moje objednávky</h5>
        <?php if (empty($orders)): ?>
            <p>Nemáte žádné objednávky.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Objednávka #</th>
                            <th>Datum</th>
                            <th>Adresa</th>
                            <th>Platba</th>
                            <th>Poznámka</th>
                            <th>Celková cena</th>
                            <th>Stav</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= $order['id'] ?></td>
                                <td><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></td>
                                <td><?= htmlspecialchars("{$order['street']}, {$order['city']} {$order['zip']}, {$order['country']}") ?></td>
                                <td><?= htmlspecialchars($order['payment_method']) ?></td>
                                <td><?= htmlspecialchars($order['note']) ?></td>
                                <td><?= number_format($order['total'], 0, ',', ' ') ?> Kč</td>
                                <td><?= htmlspecialchars($order['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
