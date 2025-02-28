<?php

$name = 'Adam';

$brand = 'BMW'; // komentář
$model = "E46";
$year = 2001;
$performance = 231;
$price = 41234.50;
$isDiscontinued = true;
$isLuxuryCar = true;

// indexy zacinaj od 0
$features = ['sport', 'comfort', 'large wheels']; // pole - hranatyma zavorkama
$features[0]; // sport
$features[1]; // comfort
$features[2]; // large wheels

class Book{
    public $title;
    public $price;
    public function __construct($title, $price){ // konstruktor
        $this->title = $title;
        $this->price = $price;
    }
}

$myBook = new Book(
    'Harry Potter and the Chamber of Secrets',
    500,
);

// kdyby byly private, musi se to udelat pres zapouzdreni
$myBook->price; // Harry Potter...
$myBook->price; // 500

// associative arrays
$player = [
    'name' => 'Ronaldo',
    'age' => 38,
    'goals' => 1000,
];
$player['name']; // Ronaldo
$player['age']; // 38
$player['goals']; // 1000


// pro DU_01 (vizitka)
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
    <h1 class="nadpis">Vizitka studenta <?php echo $xname?></h1>
    <div class="container">
        <div class="vizitka predni-strana">
            <img class="obrazek" alt="logo" src="./obrazky/<?php echo $logo ?>">
            <div class="company"><?php echo $company ?></div>
            <div class="slogan"><?php echo $slogan ?></div>
        </div>
        <div class="vizitka zadni-strana">
            <div class="info">
                <div class="name"><?php echo $firstName ?> <?php echo $lastName ?></div>
                <div class="position"><?php echo $isRetired ? 'Retired' : 'Active'; ?> <?php echo $position ?></div>
                <hr class="solid">
                <div class="contacts">
                    <div class="phone"><i class="fa fa-phone"></i> <?php echo $phone ?></div>
                    <div class="address"><i class="fa fa-map-marker"></i> <?php echo $street ?> <?php echo $streetNumber ?>, <?php echo $city ?>, <?php echo $country?>, <?php echo $zip ?></div>
                    <div class="domain"><i class="fa fa-globe"></i> <?php echo $domain ?></div>
                </div>
            </div>
            <div class="logo">
                <img class="maleLogo" alt="logo" src="./obrazky/<?php echo $logo ?>">
            </div>
        </div>

    </div>
</div>


</body>
</html>