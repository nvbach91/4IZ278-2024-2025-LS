<?php

$avatar = 'oh.png';
$firstName = 'Ivo';
$lastName = 'Vejmelka';
$ocupation = 'Student';
$company = 'VŠE';
$street = 'Pražská';
$propertyNumber = 21;
$orientaitonNumber = 1;
$city = 'Praha';
$phone = "+420 725 876 005";
$email = 'ivo.vejmelka@mailinator.com';
$website = 'https://eso.vse.cz/~veji03/cv01/';
$available = false;
$birthdate = '2002-08-22';
$birthDateTime = new DateTime($birthdate);
$today = new DateTime('today');
$age = $birthDateTime->diff($today)->y;


$address = $street . ' ' . $propertyNumber . '/' . $orientaitonNumber . ', ' . $city;

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Business card</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<main class="container">
        <div class="business-card front row">
            <div class="logoDiv col-sm-6">
                <img class="logo" src="<?php echo $avatar; ?>">
            </div>
            <div class="frontText col-sm-6">
                <div class="frontName">    
                    <div class="firstname"><?php echo $firstName; ?></div>
                    <div class="lastname"><?php echo $lastName; ?></div>
                </div>
                <div class="frontInfo">
                    <div>Pozice: <?php echo $ocupation; ?></div>
                    <div>Společnost: <?php echo $company; ?></div>
                    <div>Věk: <?php echo $age; ?> let</div>
                </div>
            </div>
        </div>
        <div class="business-card back row">
            <div class="backTop">  

                    <div class="firstname"><?php echo $firstName; ?> <?php echo $lastName; ?></div>

            </div>
            <div class="contacts">
                
                    <div class="address"><i class="fas fa-map-marker-alt"></i> <?php echo $address; ?></div>
                    <div><i class="fas fa-phone"></i><a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a></div>
                    <div><i class="fas fa-at"></i> <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></div>
                    <div><i class="fas fa-globe"></i> <a href="<?php echo $website; ?>"><?php echo $website; ?></a></div>
                    <div class="available"><?php echo $available ? 'Nyní nepřijímám nabídky' : 'Přijímám nabídky'; ?></div>
                
            </div>
        </div>
    </main>
</body>
</html>

