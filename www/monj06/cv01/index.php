<?php


// associative arrays
$person = [
    'name' => 'Din',
    'surname' => 'Djarin',
    'age' => 36,
    'position' => 'Bounty hunter',
    'company' => 'Mandalorians',
    'planet' => 'Mandalore',
    'location' => 'Outer Rim',
    'phoneNumber' => '+420 111111111',
    'email' => 'Diny@djaring.com',
    'web' => 'www.starwars.com',
    'avatar' => 'https://pngimg.com/d/mandalorian_PNG23.png',
    'lookingForJob' => false,
];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PHP business card">
    <meta name="keywords" content="PHP, business card, Mandalorian">
    <meta name="author" content="Jaromír Mondschein">
    <title>Document</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <main class="container">
        <h1 class="title">Business Card in PHP</h1>
        <div class="business-card-front">
            <div class="Avatar">
                <div class="logo-div"><img class='logo' src="<?php echo $person['avatar'] ?>" alt="Avatar"></div>
            </div>
            <div class="info">
                <div class="firstname"><?php echo $person['name'] ?></div>
                <div class="lastname"><?php echo $person['surname'] ?></div>
                <div class="positions">
                    <div class="position"><?php echo $person['position'] ?></div>
                    <div class="position">Part-time babysitter</div>
                    <div class="company"><?php echo $person['company'] ?></div>
                </div>
            </div>
        </div>
        <div class="business-card-back">
            <div class="info">
                <div class="firstname"><?php echo $person['name'] ?></div>
                <div class="lastname"><?php echo $person['surname'] ?></div>
                <div class="position"><?php echo $person['position'] ?></div>
            </div>
            <div class="contacts">
                <div><img class="icon" src="https://www.svgrepo.com/show/27276/planet.svg" alt="">
                    <div class="address"> <?php echo $person['planet']; ?></div>
                </div>
                <div><img class="icon" src="https://www.iconpacks.net/icons/1/free-phone-icon-504-thumb.png" alt="">
                    <div class="phone"><a href="tel:+420111111111"><?php echo $person['phoneNumber'] ?></a></div>
                </div>
                <div><img class="icon" src="https://www.svgrepo.com/show/14478/email.svg" alt="">
                    <div class="email"> <a href="mailto:veslovani@bohemianstj.cz"><?php echo $person['email'] ?></a></div>
                </div>
                <div><img class="icon" src="https://www.svgrepo.com/show/197996/internet.svg" alt="">
                    <div class="website"> <a href="www.starwars.com"><?php echo $person['web'] ?></a></div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>