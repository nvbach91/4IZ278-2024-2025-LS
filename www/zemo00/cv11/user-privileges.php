<?php
include __DIR__ . "/incl/head.html";
require_once __DIR__ . "/utilities/auth_admin.php";
require_once __DIR__ . "/Database/UsersDB.php";

$usersDB = new UsersDB();
$success = '';



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['privileges'])) {
    foreach ($_POST['privileges'] as $email => $privilege) {
        $usersDB->update([
            'update' => 'privilege = :privilege',
            'conditions' => ['email = :email'],
            'privilege' => (int)$privilege,
            'email' => $email
        ]);
    }
    $success = "Privileges updated successfully.";
}

$args = [
    'columns' => ['email', 'privilege'],
    'conditions' => []
];
$data = $usersDB->fetch($args);


?>

<div class="form-container">
    <h2>Manage User Privileges</h2>

    <?php if ($success): ?>
        <p class="success-message"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <form method="POST">
        <?php foreach ($data as $user): ?>
            <div class="form-group">
                <label class="label"><?php echo htmlspecialchars($user['email']); ?></label>
                <select class="input" name="privileges[<?php echo htmlspecialchars($user['email']); ?>]">
                    <option value="1" <?php if ($user['privilege'] == 1) echo 'selected'; ?>>1 - User</option>
                    <option value="2" <?php if ($user['privilege'] == 2) echo 'selected'; ?>>2 - Manager</option>
                    <option value="3" <?php if ($user['privilege'] == 3) echo 'selected'; ?>>3 - Admin</option>
                </select>
            </div>
        <?php endforeach; ?>

        <button class="button" type="submit">Save changes</button>
    </form>
</div>

<?php

include __DIR__ . "/incl/foot.html";

?>