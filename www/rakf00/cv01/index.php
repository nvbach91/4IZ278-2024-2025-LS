<?php


$jmeno = "Filip";
$prijmeni = "Rakús";
$vek = 21;
$povolani = "Client Integration Engineer";
$firma = "VIVnetworks s.r.o";
$ulice = "Husova 123";
$mesto = "Praha";
$telefon = "777 777 777";
$mail = "filrakus@email.com";
$web = "http://fr.dev.web";
$zamestnany = true;


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
            <h2><?php echo $jmeno ?> <?php echo " " . $prijmeni ?></h2>
            <p><?php echo $vek; ?> y/o</p>
            <h3><?php
                if ($zamestnany) {
                    echo $povolani;
                }else{
                  echo  "Jsem otevřený pracovním nabídkám";
                }

                ?></h3>
            <p><?php echo $firma ?></p>
            <address>
                <?php echo $ulice . ", " . $mesto ?>
            </address>
            <div class="clickAble">
            <a href="<?php echo "tel:+420" . $telefon; ?>"><?php echo "+420 " . $telefon; ?></a>
            <a href="mailto:<?php echo $mail; ?>"><?php echo $mail; ?></a>
            <a id="website" href="<?php echo $web; ?>" target="_blank">WEB</a>
            </div>
        </section>
    </div>

</body>

</html>