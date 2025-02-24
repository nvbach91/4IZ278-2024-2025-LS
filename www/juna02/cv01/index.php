<?php
// Tom Hanks' Business Card Information
$name = "Tom";
$surname = "Hanks";
$profession = "Actor, Producer, Director";
$description = "Hollywood Legend, Academy Award Winner";
$company = "Playtone Productions";
$phone = "+1 310 555 1234";
$email = "tom@hanksproduction.com";
$address = "100 Universal City Plaza, Universal City, CA, USA";
$logo = "tom-hanks_503695_re4zhs.png"; 
$available_for_work = true; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tom Hanks Business Card</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <h1>Tom Hanks Business Card</h1>

    <div class="business-card">
        <!-- Front Side -->
        <div class="card front">
            <img src="<?php echo $logo; ?>" alt="Tom Hanks" class="logo">
            <div class="text">
                <h2><?php echo "$name <span class='surname'>$surname</span>"; ?></h2>
                <p><?php echo $profession; ?></p>
                <p class="description"><?php echo $description; ?></p>
            </div>
        </div>

        <!-- Back Side -->
        <div class="card back">
            <!-- Left Section (Name & Profession) -->
            <div class="left-info">
                <h2><?php echo "$name <span class='surname'>$surname</span>"; ?></h2>
                <p><?php echo $profession; ?></p>
            </div>

            <!-- Right Section (Contacts) -->
            <div class="right-info">
    <p><i class="fa-solid fa-location-dot"></i> <?php echo $address; ?></p>
    <p><i class="fa-solid fa-phone"></i> <a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a></p>
    <p><i class="fa-solid fa-envelope"></i> <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
    <p><i class="fa-solid fa-film"></i> <?php echo $company; ?></p>
    <p><i class="fa-solid fa-check-circle"></i> <?php echo $available_for_work ? "Available for collaboration" : "Not available"; ?></p>
            </div>
        </div>
    </div>
</body>
</html>