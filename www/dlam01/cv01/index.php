<?php
$BusinessCard = [
    "name" => "Saul",
    "surname" => "Goodman",
    "occupation" => "Criminal defense/Elder law",
    "dateOfBirth" => "12.11.1960",
    "phoneNumber" => "+420 960 123 456",
    "email" => "SaulGoodman@gmail.com",
    "website" => "www.bettercallsaul.com",
    "website_link" => "https://www.bettercallsaul.com",
    "logo" => "https://upload.wikimedia.org/wikipedia/en/thumb/8/8a/Better_Call_Saul_logo.svg/1200px-Better_Call_Saul_logo.svg.png",
    "address" => "9800 Montgomery Blvd NE, Albuquerque",
    "slogan1" => "In legal trouble?",
    "slogan2" => "Better call Saul!"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV01</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="center-screen">
    <div class="business-card"> <!-- front -->
    <br>
        <p class="name" style="color: red; "><?php echo $BusinessCard["name"]; ?></p>
        <p class="name" style="color: blue;"><?php echo $BusinessCard["surname"]; ?></p><br>
        <p class="title"><?php echo $BusinessCard["slogan1"]; ?></p><br>
        <p class="title"><?php echo $BusinessCard["slogan2"]; ?></p><br>
        <img src="icons/phone.svg" class="phoneNumber-icon">
        <p class="phoneNumber-text" style="font-size: 30px; display: inline;"><?php echo $BusinessCard["phoneNumber"]; ?></p>
    </div>
    <br>
    <div id="back" class="business-card"> <!-- back -->
    <p>
            <img src="icons/job.svg" class="icon">
            <?php echo $BusinessCard["occupation"]; ?><br>
            <img src="icons/age.svg" class="icon">
            <?php
            $dateOfBirth = new DateTime($BusinessCard["dateOfBirth"]);
            $currentDate = new DateTime();
            $age = $currentDate->diff($dateOfBirth)->y;
            echo $age . " years";
            ?><br>
            <img src="icons/address.svg" class="icon">
            <?php echo $BusinessCard["address"]; ?><br>
            <img src="icons/mail.svg" class="icon">
            <?php echo $BusinessCard["email"]; ?><br>
            <a href="<?php echo $BusinessCard["website_link"]; ?>" target="_blank">
                <img src="icons/website.svg" class="icon">
                <?php echo $BusinessCard["website"]; ?>
            </a><br>
            <img src="<?php echo $BusinessCard['logo']; ?>" alt="Logo" class="logo">
        </p>
        </div>
    </div>
</body>
</html>
