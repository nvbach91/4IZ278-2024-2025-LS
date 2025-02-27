<?php
$nameFirst = 'Jakub';
$nameLast = 'Adam';
$profession = 'IT Analytik';
$nameCompany = 'Microsoft';
$street = 'Brumlovka';
$numberBuilding = '1561';
$numberOrientation = '/4a';
$city = 'Praha';
$telephone = '+420 700 600 500';
$email = 'jakub.adam@microsoft.com';
$web = 'jakub.adam.cz';
$year = date('Y') - date('Y', strtotime('2002-01-01'));
$available = false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Vizitka - Jakub Adam</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.png">
</head>
<body>
<div class="container">
  <div class="cardos row">

    <div class="col-sm-6">
    <img src="assets/images/profile.webp" alt="My Photo">
    </div>

    <div class="col-sm-6 upper-text">
    <p class="name"> <?php echo $nameFirst; ?> <?php echo $nameLast; ?> </p>
    <p class="profession"> <?php echo $profession; ?> </p>
    <p class="company">Ve společnosti <?php echo $nameCompany; ?> </p>
    <p class="year"> Věk: <?php echo $year; ?> let</p>
    </div>
  </div>
  <div class="cardos row">
    <div class="col-sm-6">
    <img src="assets/images/microsoft.png" alt="Microsoft">
    </div>

    <div class="col-sm-6 down-text">
    <p class="address"><i class="fas fa-map-marker-alt"></i> <?php echo $street; ?> <?php echo $numberBuilding; ?><?php echo $numberOrientation; ?>, <?php echo $city; ?></p>
    <p class="telephone"><i class="fas fa-phone"></i> <a href="tel:+420700600500"><?php echo $telephone; ?></p>
    <p class="email"><i class="fas fa-at"></i> <a href="mailto:emailaddress@whatever.com"><?php echo $email; ?></a></p>
    <p class="web"><i class="fas fa-globe"></i> <a href="jakub.adam.cz" target="blank"><?php echo $web; ?></a></p>
    <p class="available"><i><?php echo $available ? "Nyní jsem k dispozici" : "Nyní nejsem k dispozici"; ?></i></p>
    </div>
  </div>

</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js"></script>
</body>
</html>