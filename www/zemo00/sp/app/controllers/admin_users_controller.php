<?php

require_once __DIR__ . "/../utils/authenticate_admin.php";
require_once __DIR__ . "/../models/UserDB.php";

$userDB = new UserDB();
$users = $userDB->fetchWhere([
    'is_verified' => 1
],[
    'user_id',
    'email',
    'created_at',
    'privilege'
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['privileges'] as $userId => $privilege) {

        $userId = (int) $userId;
        $privilege = (int) $privilege;

        if (!in_array($privilege, [1, 2], true)) {
            continue;
        }

        $currentPrivilege = $userDB->fetchWhere(['user_id' => $userId], ['privilege'])[0]['privilege'];
        if ($currentPrivilege != $privilege) {
            $userDB->update($userId, ['privilege' => $privilege]);
        }
    }
    $users = $userDB->fetchWhere([
        'is_verified' => 1
    ],[
        'user_id',
        'email',
        'created_at',
        'privilege'
    ]);
}

require __DIR__ . "/../views/pages/users_page.php";


?>