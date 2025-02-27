<?php
    $name = "Martin Fedorík";
    $title = "Data Scientist";
    $company = "DSolutions s.r.o.";
    $birthdate = new DateTime("2001-10-01");
    $street = "nám. Winstona Churchilla";
    $building_number = 4;
    $location_number = 1938;
    $post_number = "120 00";
    $city = "Praha 3-Žižkov";    
    $phone = "+420123123123";
    $email = "martinfedorik@seznam.cz";
    $website = "https://www.martinfedorik.com";
    $looking_for_work = False;
    $expertise = "Machine Learning • Optimization • Automation";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Business card</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="card front">
        <div class="logo-container">
            <img src="img/logo.png" alt="Company Logo" class="logo">
        </div>
        <div class="card-content">
    <div class="name"><?php echo $name; ?></div>
    <div class="title"><?php echo $title; ?></div>
    <div class="company"><?php echo $company; ?></div>
    <div class="contact-info">
        <ul>
            <li>
                <i class="fas fa-birthday-cake"></i>
                <?php 
                    $today = new DateTime();
                    $age = $today -> diff($birthdate) -> y;
                    echo $age; 
                ?> years old
            </li>
            <li>
                <i class="fas fa-envelope"></i>
                <a class="mail" href="mailto:<?php echo $email; ?>"><?php echo $email ?></a>
            </li>
            <li>
                <i class="fas fa-phone"></i>
                <a class="phone" href="tel:<?php echo $phone; ?>"><?php echo $phone ?></a>
            </li>
            <li>
                <i class="fas fa-globe"></i>
                <a class="website" href="<?php echo $website; ?>"><?php echo $website ?></a>
            </li>
            <li>
                <i class="fas fa-map-marker-alt"></i>
                <?php echo $street . " " . $location_number . "/" . $building_number . ", " . $post_number . " " . $city ?>
            </li>
        </ul>
    </div>
</div>
    </div>
    <div class="card back">
        <div class="name-back"><?php echo $name; ?></div>
        <div class="work-indicator">
            <?php if ($looking_for_work) {echo "Currently looking for work";} else
            {echo "Not looking for work at the moment";}?>
        </div>
        <div class="divider"></div>
        <div class="expertise"><?php echo $expertise; ?></div>
    </div>
</body>
</html>