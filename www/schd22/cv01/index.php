
<?php

$me = [
    'lastName' => 'Schneider',
    'name' => 'David',
    'age' => 22,
    'job' => 'student',
    'firm' => 'Pierce & Pierce',
    'street' => '55 West 81st Street',
    'cityNumber' => 10024,
    'city' => 'New York',
    'mobile' => '518-308-3928',
    'web' => 'eso.vse.cz/~schd22/cv01/'
];
$me['lastName'];
$me['name'];
$me['age'];
$me['job'];
$me['firm'];
$me['street'];
$me['cityNumber'];
$me['city'];
$me['mobile'];
$me['web'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="front">
        <div class="contact">
            <div class ="mobile"><?php echo $me['mobile']; ?></div>
            <div class ="firm"><?php echo $me['firm']; ?></div>
        </div>    
        <div class="header">
            <div class ="name"><?php echo $me['name'] . ' ' . $me['lastName']; ?></div>
            <div class ="job"><?php echo $me['job']; ?></div>
        </div>
        <div class="place">
            <div class ="street"><?php echo $me['street']; ?></div>
            <div class ="city"><?php echo $me['city']; ?></div>
            <div class ="cityNumber"><?php echo $me['cityNumber']; ?></div>
        </div>
    </div>
    <div class="back">
        <div class="firm">
            <div class ="web"><?php echo $me['web']; ?></div>   
            <div class ="age"><?php echo 'Age: ' . $me['age']; ?></div>
        </div>
    </div>
    <div class="paul">
        Let's see Paul Allen's card.
    </div>
</body>
</html>