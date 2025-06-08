<?php include __DIR__ . '/../prefix.php'; ?>
<?php include __DIR__.'/../privileges.php'; ?>
<?php require_once __DIR__ .'/../vendor/autoload.php'; ?>
<?php require_once __DIR__.'/../database/UsersDB.php';?>
<?php require_once __DIR__ . '/../utils/Logger.php'; ?>
<?php

hasPrivilege(2);
$csrf = new \ParagonIE\AntiCSRF\AntiCSRF;
$usersDB = new UsersDB();
$log = AppLogger::getLogger();
$privilegeFilter = isset($_GET['privilege']) ? $_GET['privilege'] : 0;

if ($privilegeFilter>0) {
    $users = $usersDB->fetchUsersByPrivilege($privilegeFilter);
} else {
    $users = $usersDB->fetchAll([]);
}

if (!$users) {
    $users = [];
}

if (isset($_POST['change_privilege']) && isset($_POST['user_id']) && isset($_POST['privilege'])) {
    if (!$csrf->validateRequest()) {
        echo 'Invalid CSRF token';
        http_response_code(403);
        $log->error('Invalid CSRF token on users.php', [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);
        exit();
    }
    $userID = (int)$_POST['user_id'];
    $privilege = (int)$_POST['privilege'];
    $usersDB->updatePrivilege($userID, $privilege);
    $log->info('User privilege updated', [
        'user_id' => $userID,
        'new_privilege' => $privilege
    ]);
    header('Location: '.$urlPrefix.'/admin/users.php');
    exit();
}
?>

<?php include __DIR__.'/../includes/head.php';?>
<div class="container">
    <?php include __DIR__.'/users-users.php';?>
</div>

<?php include __DIR__.'/../includes/foot.php';?>