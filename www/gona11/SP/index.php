<?php require __DIR__ . '/includes/head.php'; ?>
<?php require __DIR__ . '/requires/navbar.php'; ?>
<?php 
    date_default_timezone_set('Europe/Prague');
    if(isset($_SESSION["loginSuccess"])) {
        $loginSuccess = $_SESSION["loginSuccess"];
        unset($_SESSION["loginSuccess"]);
    }

    if(isset($_SESSION["logoutSuccess"])) {
        $logoutSuccess = $_SESSION["logoutSuccess"];
        unset($_SESSION["logoutSuccess"]);
    }

    if(isset($_SESSION["openProductFail"])) {
        $openProductFail = $_SESSION["openProductFail"];
        unset($_SESSION["openProductFail"]);
    }

    if(isset($_SESSION["openUserFail"])) {
        $openUserFail = $_SESSION["openUserFail"];
        unset($_SESSION["openUserFail"]);
    }

        if(isset($_SESSION["updateStatusFailed"])) {
        $updateStatusFailed = $_SESSION["updateStatusFailed"];
        unset($_SESSION["updateStatusFailed"]);
    }
?>

    <?php if(isset($loginSuccess)) :?>
        <div class="alert alert-success mt-3"><?php echo $loginSuccess;?></div>
    <?php endif; ?>

    <?php if(isset($logoutSuccess)) :?>
        <div class="alert alert-warning mt-3"><?php echo $logoutSuccess;?></div>
    <?php endif; ?>

    <?php if(isset($openProductFail)) :?>
        <div class="alert alert-warning mt-3"><?php echo $openProductFail;?></div>
    <?php endif; ?>

    <?php if(isset($openUserFail)) :?>
        <div class="alert alert-warning mt-3"><?php echo $openUserFail;?></div>
    <?php endif; ?>

    <?php if(isset($updateStatusFailed)) :?>
        <div class="alert alert-warning mt-3"><?php echo $updateStatusFailed;?></div>
    <?php endif; ?>

<div class="image_wrapper">
    <img class="landing_image" src="https://eso.vse.cz/~gona11/SP/assets/landing.jpg" alt="">
    <h1 class="text">Vybavíme vás na jakoukoliv výpravu.</h1>
</div>
<?php require __DIR__ . '/includes/foot.php'; ?>
