<?php

$name = 'Adam';

$brand = 'BMW'; // "
$model = 'iX';
$year = 2024;
$performance = 200;
$price = 41234.50;
$isDiscontinued = false;
$isLuxuryCar = true;
// index 0        1          2
$features = ['sport', 'comfort', 'large wheels'];
$features[0]; // sport
$features[1]; // comfort
$features[2]; // large wheels

class Book
{
  public $title;
  public $price;
  public function __construct($title, $price)
  {
    $this->title = $title;
    $this->price = $price;
  }
}

$myBook = new Book(
  'Harry Potter and the Chamber of Secrets',
  500,
);

$myBook->title; // Harry Potter ...
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

?>


<?php

$firstName = 'David';
$lastName = 'Beckham';
$email = 'david@beckham.com';
$profession = 'Football player';
$position = 'Midfielder/Winger';
$salary = 500000;
$currency = 'EUR';
$logo = 'https://upload.wikimedia.org/wikipedia/en/thumb/5/56/Real_Madrid_CF.svg/800px-Real_Madrid_CF.svg.png';
$birthYear = 1975;
$age = date('Y') - $birthYear;
$company = 'Real Madrid C.F.';
$street = 'Avenida de Concha Espina 1';
$city = 'Madrid';
$zip = '28036';
$phone = '+34 91 3984300';
$web = 'https://www.realmadrid.com';
$isRetired = true;

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
    <div class="bc-firstName"><?php echo $firstName; ?></div>
    <div class="bc-lastName"><?php echo $lastName; ?></div>
    <div class="bc-email">
      <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
    </div>
    <div class="bc-profession"><?php echo $profession; ?></div>
    <div class="bc-position"><?php echo $position; ?></div>
    <div class="bc-salary">Salary: <?php echo $salary; ?><?php echo $currency; ?></div>
    <div class="bc-logo">
      <img src="<?php echo $logo; ?>" width="70">
    </div>
    <div class="bc-birthYear">Date of birth: <?php echo $birthYear; ?></div>
    <div class="bc-age">Age: <?php echo $age; ?></div>
    <div class="bc-company"><?php echo $company; ?></div>
    <div class="bc-street"><?php echo $street; ?></div>
    <div class="bc-city">
      <?php echo $city; ?>, <?php echo $zip; ?>
    </div>
    <div class="bc-phone">
      <a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a>
    </div>
    <div class="bc-web">
      <a href="<?php echo $web; ?>" target="_blank">Official website</a>
    </div>
    <div class="bc-isRetired"><?php echo $isRetired ? 'Retired' : 'Active'; ?></div>
  </div>
</body>

</html>