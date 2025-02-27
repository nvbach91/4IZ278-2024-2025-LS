<?php 
$logo;
$name = ['Kateřina', 'Karásková'];
$dob = date_create_from_format("j.n.Y", "6.6.2003");
$work = 'Working student';
$position = 'Web Content Support';
$company = 'Siemens';
$street = 'Siemensova';
$pNumber = '1';
$oNumber = '2715';
$city = 'Prague';
$phone = '+420123123123';
$email = 'katerina.karaskova@siemens.com';
$website = 'siemens.com';
$toWork = false;
$today = date("j.m.Y",);

$age = date_diff($dob, new DateTime('now')) ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business card</title>
    <link rel="stylesheet" href="./stylesheet.css">
    <script src="https://kit.fontawesome.com/1b73125708.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="card">
        <img src="assets/Siemens_AG_logo.svg" alt="Siemens logo">
    </div>
    <div class="card">
        <h1> <?php echo $name[1] . " " . $name[0];
        
        ?> </h1>
        <p id="age"><?php echo $age->format("%Y"); ?></p>
        <p id="position">
            <?php
                echo $position . " | " . $work;
             ?></p>
            <hr>
        <div class="contact">
            <p><a href=<?php echo "mailto:" . $email; ?>><i class="fa-solid fa-at"></i> <?php echo $email; ?></a></p>
            <p><i class="fa-solid fa-phone-flip"></i> <?php echo $phone; ?></p>
            <p><a href=<?php echo $website; ?>><i class="fa-solid fa-globe"></i> <?php echo $website; ?></a></p>
        </div>
        <div class="address">
            <p><?php echo $company ?></p>
        <p><?php echo $street . " " . $oNumber . "/" . $pNumber ?></p>
            <p><?php echo $city ?></p>
        </div>
        </div>
</body>
</html>