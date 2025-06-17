<?php
require_once __DIR__ . '/includes/init.php';

$successMessage = '';
$errors = [];

if (isset($_GET['registered']) && $_GET['registered'] == '1') {
    $successMessage = 'Registrace proběhla úspěšně. Nyní se můžete přihlásit.';
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $errors[] = "Zadejte prosím email a heslo.";
    } else {
        $pdo = (new Database())->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'email' => $user['email'],
                'is_admin' => $user['is_admin']
            ];

            if (isset($_SESSION['redirect_after_login'])) {
                $redir = $_SESSION['redirect_after_login'];
                unset($_SESSION['redirect_after_login']);

                if (!empty($redir['add_to_cart']) && !empty($redir['product_id'])) {
                    $pid = (int)$redir['product_id'];
                    $qty = (int)($redir['quantity'] ?? 1);

                    if (!isset($_SESSION['cart'])) {
                        $_SESSION['cart'] = [];
                    }

                    if (isset($_SESSION['cart'][$pid])) {
                        $_SESSION['cart'][$pid] += $qty;
                    } else {
                        $_SESSION['cart'][$pid] = $qty;
                    }
                }

                header("Location: cart.php");
                exit;
            }

            if ($user['is_admin'] == 1) {
                header("Location: admin/products.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $errors[] = "Neplatný email nebo heslo.";
        }
    }
}
?>

<?php include __DIR__ . '/includes/head.php'; ?>
<?php include __DIR__ . '/includes/navbar.php'; ?>

<main class="container mt-5" style="max-width: 500px;">
    <h2>Přihlášení</h2>

    <?php renderMessages($successMessage, $errors);?>

    <form method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars($email ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Heslo</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>
        <button type="submit" class="btn btn-primary w-100">Přihlásit se</button>
    </form>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
