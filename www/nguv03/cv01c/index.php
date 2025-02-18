<?php


$name = 'Adam'; // String
$birthYear = 2000; // integer
$moneyAmount = 12345.12; // float/double
$isMarried = false;
$isEmployed = true;
        // index   0            1           2
$favoriteMovies = ['Kill Bill', 'Avengers', 'Thor'];
$favoriteMovies[0]; // Kill Bill
$favoriteMovies[1]; // Avengers
$favoriteMovies[2]; // Thor

class Book {
    public $title;
    public $price;
    public function __construct($title, $price) {
        $this->title = $title;
        $this->price = $price;
    }
}

$myBook = new Book(
    'Harry Potter and the Chamber of Secrets',
    123,
);

$myBook->title; // Harry Potter ...
$myBook->price; // 123
?>

<?php
$name = 'Arnold';
$lastName = 'Schwarzeneger';
$profession = 'Politician / ActorActor';
$email = 'arnold@schwarzeneger.com';
$phone = '+420 123 456 789';
$logo = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQHFeRWiZiBOlJ3uMufoY0qgGu1IbcDGJ3oFQ&s';
$street = 'Wall Street 321';
$zip = 32165;
$city = 'New York City';
// vytvorit vizitku
// s informacemi o cloveku
// jmeno, prijmeni, telefon, email, web, profese, pozice, logo, company name, adresa (ulice, cp/co, psc, mesto)
// ----------------------------------
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <div class="business-card">
        <div class="bc-name"><?php echo $name; ?></div>
        <div class="bc-lastName"><?php echo $lastName; ?></div>
        <div class="bc-profession"><?php echo $profession; ?></div>
        <div class="bc-street"><?php echo $street; ?></div>
        <div class="bc-zip"><?php echo $zip; ?></div>
        <div class="bc-city"><?php echo $city; ?></div>
        <div class="bc-email">
            <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></div>
        <div class="bc-phone">
            <a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a>
        </div>
        <div class="bc-logo">
            <img src="<?php echo $logo; ?>" alt="logo">
        </div>
    </div>
</body>
</html>