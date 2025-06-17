<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../database-config/UsersDB.php';

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    header('Location: /~adaj12/test/pages/user.php?error=Nejste přihlášen(a).');
    exit;
}

$usersDB = new UsersDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    // Změna hesla
    if ($action === 'change_password') {
        $old = $_POST['old_password'] ?? '';
        $new1 = $_POST['new_password'] ?? '';
        $new2 = $_POST['new_password2'] ?? '';
        if (!$old || !$new1 || !$new2) {
            header('Location: /~adaj12/test/pages/user.php?error=Vyplňte všechna pole.');
            exit;
        }
        $user = $usersDB->findById($userId);
        if (!$user || !password_verify($old, $user['password'])) {
            header('Location: /~adaj12/test/pages/user.php?error=Chybné staré heslo.');
            exit;
        }
        if ($new1 !== $new2) {
            header('Location: /~adaj12/test/pages/user.php?error=Nová hesla se neshodují.');
            exit;
        }
        if (strlen($new1) < 6) {
            header('Location: /~adaj12/test/pages/user.php?error=Nové heslo musí mít alespoň 6 znaků.');
            exit;
        }
        $usersDB->updatePassword($userId, password_hash($new1, PASSWORD_DEFAULT));
        header('Location: /~adaj12/test/pages/user.php?success=Heslo úspěšně změněno.');
        exit;
    }

   // Úprava profilu
    if ($action === 'update_profile') {
        $name = trim($_POST['name'] ?? '');
        $avatarFile = $_POST['selected_avatar'] ?? '';
        $allowedAvatars = [
            '/~adaj12/test/assets/avatars/girl1.png',
            '/~adaj12/test/assets/avatars/girl2.png',
            '/~adaj12/test/assets/avatars/girl3.png',
            '/~adaj12/test/assets/avatars/man1.png',
            '/~adaj12/test/assets/avatars/man2.png',
            '/~adaj12/test/assets/avatars/man3.png'
        ];
        if (!in_array($avatarFile, $allowedAvatars)) {
            $avatarFile = '';
        }
        // Nové dodací údaje
        $shipping_name = trim($_POST['shipping_name'] ?? '');
        $shipping_street = trim($_POST['shipping_street'] ?? '');
        $shipping_postal_code = trim($_POST['shipping_postal_code'] ?? '');
        $shipping_city = trim($_POST['shipping_city'] ?? '');
        $shipping_phone = trim($_POST['shipping_phone'] ?? '');

        // VALIDACE dodacích údajů – jen pokud jsou vyplněny
        $error = '';
        if ($shipping_name !== '' && strlen($shipping_name) < 3) $error = 'Zadejte jméno a příjmení (alespoň 3 znaky).';
        if ($shipping_street !== '' && strlen($shipping_street) < 3) $error = 'Zadejte ulici a číslo popisné (alespoň 3 znaky).';
        if ($shipping_postal_code !== '' && !preg_match('/^\d{3}\s?\d{2}$/', $shipping_postal_code)) $error = 'Zadejte platné PSČ (např. 11000 nebo 110 00).';
        if ($shipping_city !== '' && strlen($shipping_city) < 2) $error = 'Zadejte město (alespoň 2 znaky).';
        if ($shipping_phone !== '' && !preg_match('/^\d{9}$/', $shipping_phone)) $error = 'Zadejte telefon ve tvaru 123456789 (9 číslic bez mezer).';

        if ($error) {
            header('Location: /~adaj12/test/pages/user.php?error=' . urlencode($error));
            exit;
        }

        $usersDB->updateProfileWithAddress($userId, $name, $avatarFile, $shipping_name, $shipping_street, $shipping_postal_code, $shipping_city, $shipping_phone);
        $_SESSION['user_name'] = $name;
        $_SESSION['user_avatar'] = $avatarFile;
        $_SESSION['shipping_name'] = $shipping_name;
        $_SESSION['shipping_street'] = $shipping_street;
        $_SESSION['shipping_postal_code'] = $shipping_postal_code;
        $_SESSION['shipping_city'] = $shipping_city;
        $_SESSION['shipping_phone'] = $shipping_phone;
        header('Location: /~adaj12/test/pages/user.php?success=Profil upraven.');
        exit;
    }

    // Smazání účtu – kontrola stavů objednávek
    if ($action === 'delete_account') {
        $confirm = $_POST['confirm_password'] ?? '';
        $user = $usersDB->findById($userId);
        if (!$user || !password_verify($confirm, $user['password'])) {
            header('Location: /~adaj12/test/pages/user.php?error=Chybné heslo.');
            exit;
        }

        // Kontrola všech objednávek
        require_once __DIR__ . '/../../database-config/OrdersDB.php';
        $ordersDB = new OrdersDB();
        $orders = $ordersDB->getOrdersByUserId($userId);

        $allDelivered = true;
        foreach ($orders as $order) {
            if (mb_strtolower(trim($order['status'])) !== 'dodáno') {
                $allDelivered = false;
                break;
            }
        }
        if (!$allDelivered) {
            header('Location: /~adaj12/test/pages/user.php?error=Účet nelze zrušit, dokud nejsou všechny vaše objednávky doručeny.');
            exit;
        }

        // Odpojení uživatele od objednávek
        foreach ($orders as $order) {
            $ordersDB->detachUserFromOrder($order['id']);
        }

        // Smazání uživatele 
        $usersDB->delete($userId);
        session_unset();
        session_destroy();
        header('Location: /~adaj12/test/index.php?success=Účet byl zrušen.');
        exit;
    }
}

header('Location: /~adaj12/test/pages/user.php?error=Neplatná akce.');
exit;
