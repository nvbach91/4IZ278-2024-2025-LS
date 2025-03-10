<?php


$firstName = "Filip";
$surname = "Rakús";
$age = 21;
$job = "Client Integration Engineer";
$company = "VIVnetworks s.r.o";
$street= "Husova 123";
$city = "Praha";
$phone = "777 777 777";
$mail = "filrakus@email.com";
$web = "http://fr.dev.web";
$lookingForJob = true;


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vizitka</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">
    <section><img src="logo.png" alt="logo"></section>
    <section id="aboutMe">
        <h2><?php echo $firstName ?> <?php echo " " . $surname ?></h2>
        <p><?php echo $age; ?> y/o</p>
        <h3><?php
            if ($lookingForJob) {
                echo "Jsem otevřený pracovním nabídkám";
            }else{
                echo $job;
            }

            ?></h3>
        <p><?php echo $company ?></p>
        <address>
            <?php echo $street . ", " . $city ?>
        </address>
        <div class="clickAble">
            <a href="<?php echo "tel:+420" . $phone; ?>"><?php echo "+420 " . $phone; ?></a>
            <a href="mailto:<?php echo $mail; ?>"><?php echo $mail; ?></a>
            <a id="website" href="<?php echo $web; ?>" target="_blank">WEB</a>
        </div>
    </section>
</div>

</body>

</html>