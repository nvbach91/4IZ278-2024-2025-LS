<?php
$name = 'Bill';
$lastName = 'Gates';
$profession = 'Philanthropist / Software Developer';
$email = 'bill@gatesfoundation.org';
$phone = '+1 206 709 3100';
$logo = 'logo.jpg'; 
$street = '500 5th Ave N';
$zip = 98109;
$city = 'Seattle, WA';
$company = 'Bill & Melinda Gates Foundation';
$description = "Co-founder of Microsoft & Philanthropist";
$available_for_work = false; 


$address = "$street, $zip, $city";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Gates Business Card</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

<h1>Bill Gates Business Card</h1>

<div class="business-card">
    <div class="card-container">
        <!-- Передняя сторона -->
        <div class="card front">
            <img src="<?php echo $logo; ?>" alt="Bill Gates" class="logo">
            <div class="text">
                <h2><?php echo "$name <span class='surname'>$lastName</span>"; ?></h2>
                <p><?php echo $profession; ?></p>
                <p class="description"><?php echo $description; ?></p>
            </div>
        </div>

        <!-- Задняя сторона -->
        <div class="card back">
            <div class="contact-info">
                <h2><?php echo "$name <span class='surname'>$lastName</span>"; ?></h2>
                <p><?php echo $profession; ?></p>
                <p><i class="fa-solid fa-location-dot"></i> <?php echo $address; ?></p>
                <p><i class="fa-solid fa-phone"></i> <a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a></p>
                <p><i class="fa-solid fa-envelope"></i> <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
                <p><i class="fa-solid fa-building"></i> <?php echo $company; ?></p>
                <p><i class="fa-solid fa-check-circle"></i> <?php echo $available_for_work ? "Available for collaboration" : "Not available"; ?></p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
