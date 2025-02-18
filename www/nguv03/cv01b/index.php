<?php

$name = 'Adam';
$height = 180;
$birthYear = 2000;
$moneyAmount = 42000.12;
$moneyCurrency = 'EUR';
$isMarried = true;
$isEmployed = false;
// indexes   0      1       2             3
$favoritePets = ['cats', 'dogs', 'crocodiles', 'butterflies'];
$favoritePets[0]; // cats
$favoritePets[1]; // dogs
$favoritePets[2]; // crocodiles
$favoritePets[3]; // butterflies
class Book
{
    public $title;
    public $price;
    function __construct($title, $price)
    {
        $this->title = $title;
        $this->price = $price;
    }
}
$myBook = new Book(
    'Harry Potter and the Chamber of Secrets',
    123.00,
);
$myBook->title;
$myBook->price;



// vymyslet vizitku (
//    jmeno, prijmeni, vek, profese, telefon
//    pozice, web, adresa (ulice, cp/co, psc, mesto)
//    logo
//)
// $name
// $lastName
// $age
// $profession
// ...
$name = 'John';
$lastName = 'Smith';
$profession = 'Graphics Designer';
$position = 'Manager';
$phone = '+420 123 456 789';
$email = 'john@smith.com';
$street = 'Wall Street 123';
$zip = '65498';
$city = 'New York City';
$logo = 'https://lumiere-a.akamaihd.net/v1/images/image_5c51d8fe.jpeg';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business card</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="business-card">
        <div class="bc-name"><?php echo $name; ?></div>
        <div class="bc-lastName"><?php echo $lastName; ?></div>
        <div class="bc-profession"><?php echo $profession; ?></div>
        <div class="bc-position"><?php echo $position; ?></div>
        <div class="bc-phone">
            <a href="tel:<?php echo $phone; ?>">
                <?php echo $phone; ?>
            </a>
        </div>
        <div class="bc-email">
            <a href="mailto:<?php echo $email; ?>">
                <?php echo $email; ?>
            </a>
        </div>
        <div class="bc-street"><?php echo $street; ?></div>
        <div class="bc-zip"><?php echo $zip; ?></div>
        <div class="bc-city"><?php echo $city; ?></div>
        <div class="bc-logo">
            <img src="<?php echo $logo; ?>" alt="logo">
        </div>
    </div>
</body>

</html>