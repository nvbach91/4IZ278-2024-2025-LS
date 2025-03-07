<?php require './classes/Person.php'; ?>
<?php

$xname = 'kvik01';
$logo = 'Liqui-moly.png'; // odkaz na obrazek na internetu, takze https...
$company = 'Liqui Moly Racing Team';
$slogan = '"Victory is the goal, speed is the means."';
$firstName = 'Chris';
$isRetired = false;
$lastName = 'One';
$position = 'Racing Driver';
$phone = '+305 777 666 555';
$street = 'Bellevue Ave.';
$streetNumber = 742;
$city = 'Florida';
$country = 'USA';
$zip = 34683;
$email = 'chrisone@liquimolyracing.com';
$domain = 'www.liqui-moly.com';


$person1 = new Person('Chris', 'One', 'racing driver', '+305 777 666 555', 'Bellevue Ave.', 742, 'Florida', 'USA', 34683);
$person2 = new Person('Ken', 'Block', 'stunt driver', '+305 777 777 777', 'Happy Street', 68, 'Praha', 'Česko', 12345);
$person3 = new Person('Tanner', 'Foust', 'street racer', '+305 777 666 111', 'Sunny Street', 37, 'Berlin', 'Německo', 78945);
$people = [$person1, $person2, $person3];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Kanit' rel='stylesheet'>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

<div class="businessCard">
    <h1 class="nadpis">Vizitky studenta <?php echo $xname?></h1>
    <?php foreach($people as $person): ?>
        <div class="container">
            <div class="vizitka predni-strana">
                <img class="obrazek" alt="logo" src="./obrazky/<?php echo $logo ?>">
                <div class="company"><?php echo $company ?></div>
                <div class="slogan"><?php echo $slogan ?></div>
            </div>
            <div class="vizitka zadni-strana">
                <div class="info">
                    <div class="name"><?php echo $person->getFullName(); ?></div>
                    <div class="position"><?php echo $person->position; ?></div>
                    <hr class="solid">
                    <div class="contacts">
                        <div class="phone"><i class="fa fa-phone"></i> <?php echo $person->phone; ?></div>
                        <div class="address"><i class="fa fa-map-marker"></i> <?php echo $person->getAddress(); ?></div>
                        <div class="domain"><i class="fa fa-globe"></i> <?php echo $domain ?></div>
                    </div>
                </div>
                <div class="logo">
                    <img class="maleLogo" alt="logo" src="./obrazky/<?php echo $logo ?>">
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<!-- <div>
    <?php foreach($persons as $person): ?>
        <div><?php echo $person->name; ?></div>
        <div><?php echo $person->email; ?></div>
        <div><?php echo $person->getFullBankAccountNumber(); ?></div>
    <?php endforeach; ?>
</div> -->

</body>
</html>