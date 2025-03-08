<?php
$name = "Amanda";
$lastName = "Doe";
$profession = "Software Developer";
$phone = "+1 123 456 789";
$email = "amandadoe@gmail.com";
$address = "Wall Street 321";
$zipCity = "32165, New York City";
$companyName = "SonarSource";
$companyWebsite = "https://www.sonarsource.com";
$logoURL = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRBefscL_EVFyBklxeEL3DucbQgrZ07c-RYqg&s";
$isEmployed = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Card</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="business-card">
        <div class="header"><?php echo "$name $lastName"; ?></div>
        <div class="profession"><?php echo $profession; ?></div>
        <div class="employment-status">
            <?php echo $isEmployed ? "Currently Employed" : "Looking for a Job"; ?>
        </div>
        <div class="separator"></div>
        <div class="contact">
            <p><a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a></p>
            <p><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
        </div>
        <div class="address">
            <p><?php echo $address; ?></p>
            <p><?php echo $zipCity; ?></p>
        </div>
        <div class="company-logo">
            <img src="<?php echo $logoURL; ?>" alt="Company Logo">
        </div>
        <div class="company-container">
            <div class="company-info">
                <div class="company-name"><?php echo $companyName; ?></div>
                <div class="website">
                    <a href="<?php echo $companyWebsite; ?>"><?php echo parse_url($companyWebsite, PHP_URL_HOST); ?></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
