<?php include __DIR__.'/privileges.php'; ?>
<?php
    unset($_SESSION['user']);
    header('Location: ./index.php');
    exit();
?>