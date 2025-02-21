<?php

$firstName = 'Steve';
$lastName = 'Jobs';
$photo= 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/dc/Steve_Jobs_Headshot_2010-CROP_%28cropped_2%29.jpg/800px-Steve_Jobs_Headshot_2010-CROP_%28cropped_2%29.jpg';
$logo= 'https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg';
$birth = 1955;
$age=date('Y')-$birth;
$job = 'CEO';
$company = 'Apple Inc.';
$streetNumber = 1;
$street = 'Apple Park Way';
$city = 'Cupertino';
$state='CA';
$zip = 95014;
$country = 'United States';
$email = 'CEO@apple.com';
$web='www.apple.com';
$searchingEmployees=false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Document</title>
</head>
<body>
    <div class="card">
        <div class="column">
            <img class="photo" src=<?php echo $photo; ?> alt="Profile picture">
            <div class="name"><?php echo "$firstName $lastName"; ?></div>
            <!-- <div class="age"><?php echo $age; ?> years old</div> -->
            <div class="job"><?php echo $job; ?> at <?php echo $company; ?></div>
            <div class="email">Email: <a href="mailto:<?php echo $email; ?>"> <?php echo $email; ?> </a></div>
            <div class="searchingEmployees"><?php echo $searchingEmployees ? 'Looking for new employees.' : 'Not hiring at the moment.'; ?></div>
        </div>
        <div class="column">
                
            <div class="adress">
                <div class="adressLine"><?php echo $company; ?></div>
                <div class="adressLine"><?php echo "$streetNumber $street"; ?></div>
                <div class="adressLine"><?php echo "$city, $state $zip"; ?></div>
                <div class="adressLine"><?php echo $country; ?></div>
            </div>
            <div class="web"><a href=<?php echo $web; ?>><?php echo $web; ?></a></div>
            <img class="logo" src=<?php echo $logo; ?> alt="Company logo">
        </div>
        
</div>
</body>
</html>