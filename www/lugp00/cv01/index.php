<?php

$firstName = "Jan";
$lastName = "Novak";
$birthDate = "2000-01-1";
$age = date_diff(date_create($birthDate), date_create('today'))->y;

$job = "Web Developer";
$company = "Novak Webs sro";
$street = "Hlavni ulice";
$houseNumber = "1234";
$orientationNumber = "5";
$city = "Praha";
$phone = "+420 123 456 789";
$email = "emailova_adresa@email.com";
$website = "https://www.jannovakuvweb.com";
$lookingForJob = true;
$picture = "picture.png";

$lookingForJobText = $lookingForJob ? "Yes" : "No";
?>

<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vizitka</title>
  <style>
    body {
      margin: 20px;
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
    }

    .card {
      width: 300px;
      height: 150px;
      margin: 20px auto;
      box-sizing: border-box;
      border: 4px solid #ff8c00;
      border-radius: 8px;
      background-color: #fff7e6;

      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 10px;
    }

    .card img {
      width: 50px;
      height: 50px;
      margin-bottom: 5px;
      border-radius: 50%;
      object-fit: cover;
    }

    .card h1 {
      margin: 0;
      font-size: 16px;
      color: #333;
      line-height: 1.2;
    }

    .card p {
      margin: 3px 0;
      font-size: 13px;
      line-height: 1.2;
      color: #333;
    }

    a {
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }

  </style>
</head>
<body>

  <div class="card">
    <img src="<?php echo $picture; ?>">
    <h1><?php echo $firstName . " " . $lastName; ?></h1>
    <p>Age: <?php echo $age; ?></p>
    <p><?php echo $job; ?></p>
  </div>

  <div class="card">
    <p><strong><?php echo $company; ?></strong></p>
    <p><?php echo $street . " " . $houseNumber . "/" . $orientationNumber . ", " . $city; ?></p>
    <p>Tel: <?php echo $phone; ?></p>
    <p>E-mail: <?php echo $email; ?></p>
    <p>Web: <?php echo $website; ?></a></p>
    <p>Looking for job: <?php echo $lookingForJobText; ?></p>
  </div>

</body>
</html>
