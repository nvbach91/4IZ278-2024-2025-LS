<?php require __DIR__ . '/includes/head.php'; ?>
<?php require __DIR__ . '/requires/navbar.php'; ?>
<?php 
    if(isset($_SESSION["loginSuccess"])) {
        $loginSuccess = $_SESSION["loginSuccess"];
        unset($_SESSION["loginSuccess"]);
    }

    if(isset($_SESSION["logoutSuccess"])) {
        $logoutSuccess = $_SESSION["logoutSuccess"];
        unset($_SESSION["logoutSuccess"]);
    }
?>

    <?php if(isset($loginSuccess)) :?>
        <div class="alert alert-success mt-3"><?php echo $loginSuccess;?></div>
    <?php endif; ?>

    <?php if(isset($logoutSuccess)) :?>
        <div class="alert alert-warning mt-3"><?php echo $logoutSuccess;?></div>
    <?php endif; ?>

<div class="image_wrapper">
    <img class="landing_image" src="./assets/landing.jpg" alt="">
    <h1 class="text">Vybavíme vás na jakoukoliv výpravu.</h1>
</div>
<?php require __DIR__ . '/includes/foot.php'; ?>
