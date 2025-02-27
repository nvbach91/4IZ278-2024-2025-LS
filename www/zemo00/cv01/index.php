

<?php

$image = "wonka-logo.png";
$name = ["Willy", "Wonka"];
$dob = "1999-01-01";
$position = "CEO";
$company = "Wonka";
$address = [
    "street" => "Chocolate Road",
    "street_num" => 450,
    "orientation_num" => 10,
    "zip" => 41278,
    "city" => "Candyland",
    "state" => "MN"
];
$phone = "777 521 698";
$email = "ww@wonka.com";
$website = "willywonka.com";
$isLookingForWork = false;

$age = date_diff(date_create($dob), date_create(date('y-m-d')))->y;

if ($isLookingForWork){
    $work_message = "I am open for work.";
} else {
    $work_message = "I am not open for work.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <title>Willy Wonka</title>
</head>
<body>
    <section class="card">
        <img id="logo" src=<?php echo $image;?> alt="Wonka logo">
        <h3 id="name"><?php echo $name[0] . " " . $name[1]; ?></h3>
        <hr>
        <h4> <?php echo $position . " at " . $company; ?> </h4>
    </section>
    <section class="card">
        <div class="container">
            <div>
                <p> <?php echo $phone . "<br><a href=\"https://www.youtube.com/watch?v=dQw4w9WgXcQ\">" . $email . "</a><br><a href=\"https://www.youtube.com/watch?v=dQw4w9WgXcQ\">" . $website . "</a><br>" . $age . " years old";?> </p>
            </div>
            <div id="divider"></div>
            <div>
                <p> <?php echo $address["street_num"] . "/" . $address["orientation_num"] . " " . $address["street"] . "<br>" . $address["city"] . ", " . $address["state"] . " " . $address["zip"]; ?> </p>
            </div>
        </div>
        <p> <?php echo $work_message;?> </p>
    </section>
    <script src="script.js"></script>
</body>
</html>
