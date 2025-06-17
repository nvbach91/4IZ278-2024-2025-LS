<?php
require_once __DIR__ . '/includes/init.php';
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$pdo = (new Database())->getConnection();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $street = trim($_POST['street'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $zip = trim($_POST['zip'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (!$firstName || !$lastName || !$email || !$street || !$city || !$zip || !$country || !$password || !$confirmPassword) {
        $errors[] = 'Všechna pole jsou povinná.';
    } 

    $errors = array_merge($errors, validateEmail($email));
    $errors = array_merge($errors, validatePassword($password, $confirmPassword));
    
    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'Účet s tímto e-mailem již existuje.';
        }
    }

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (first_name, last_name, email, password, street, city, zip, country, is_admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)');
        $stmt->execute([$firstName, $lastName, $email, $hash, $street, $city, $zip, $country]);
        header('Location: login.php?registered=1');
        exit;
    }
}
?>

<?php include __DIR__ . '/includes/head.php'; ?>
<?php include __DIR__ . '/includes/navbar.php'; ?>

<main class="container mt-5" style="max-width: 600px;">
    <h2>Registrace</h2>
    <?php renderMessages(null, $errors);?>

    <form method="POST">
        <div class="mb-3">
            <label for="first_name" class="form-label">Jméno</label>
            <input type="text" class="form-control" name="first_name" id="first_name" value="<?= htmlspecialchars($firstName ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Příjmení</label>
            <input type="text" class="form-control" name="last_name" id="last_name" value="<?= htmlspecialchars($lastName ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars($email ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="street" class="form-label">Ulice a číslo</label>
            <input type="text" class="form-control" name="street" id="street" value="<?= htmlspecialchars($street ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">Město</label>
            <input type="text" class="form-control" name="city" id="city" value="<?= htmlspecialchars($city ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="zip" class="form-label">PSČ</label>
            <input type="text" class="form-control" name="zip" id="zip" value="<?= htmlspecialchars($zip ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="country" class="form-label">Země</label>
            <input type="text" class="form-control" name="country" id="country" value="<?= htmlspecialchars($country ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Heslo</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Potvrzení hesla</label>
            <input type="password" class="form-control" name="confirm_password" id="confirm_password">
        </div>
        <button type="submit" class="btn btn-primary w-100">Registrovat se</button>
    </form>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
