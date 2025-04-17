<?php
$authenticated = false;
session_start();
if(isset($_SESSION["email"])){
    $authenticated = true;
}



?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
if ($_SESSION["privilege"] == "3" || $_SESSION["privilege"] == "2" && $authenticated): ?>
    <h1>Zde můžete vytvořit, editovat a smazat produkt jako manager či admin</h1>
<?php
else: ?>
    <?php echo "<h1>Sem nemáte přístup</h1>"?>
<?php
endif; ?>

</body>
</html>
