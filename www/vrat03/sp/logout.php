<?php include __DIR__.'/prefix.php'; ?>
<?php include __DIR__.'/privileges.php'; ?>
<?php require_once __DIR__ . '/utils/Logger.php'; ?>
<?php
    $log = AppLogger::getLogger();
    $log->info('User logged out', [
        'user_id' => $_SESSION['user']['id'] ?? null,
        'email' => $_SESSION['user']['email'] ?? null
    ]);
    session_unset();
    header('Location: '.$urlPrefix.'/index.php');
    exit();
?>