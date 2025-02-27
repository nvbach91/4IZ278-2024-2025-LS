<?php
	$name = ["Amelie", "Engelmaierová"];
	$dateOfBirth = date_create("2004-06-30");
	$jobs = ["Computer Academy teacher", "Freelance Web Dev"];
	$companyName = "ikoronka s.r.o.";
	$streetName = "Chemická";
	$buildingNumber = "420";
	$orientationNumber = "69";
	$city = "Prague";
	$phoneNumber = 123_456_789;
	$email = "email@email.cz";
	$webpage = "https://www.ikoronka.com";
	$lookingForJob = true;

	$age = date_diff(date_create(), $dateOfBirth)->y;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ikoronka bussiness card</title>
	<link rel="stylesheet" href="cv01/main.css">
	<link rel="stylesheet" href="./main.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=DM+Mono:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
	<div id="businessCard">
		<div id="logoContainer">
			<img id="logo" src="cv01/assets/ikoronka.svg" alt="">
			<img id="logo" src="./assets/ikoronka.svg" alt="">
		</div>
		<div id="infoContainer">
			<div id="nameAndBasicInfo">
				<h1>
					<?php echo $name[0] . " " . $name[1];?>
				</h1>
				<div class="labelGroup">
					<span class="label">company</span>
					<span id="companyName"><?php echo $companyName?></span>
				</div>
				<div class="labelGroup">
					<span class="label">age</span>
					<span><?php echo $age?></span>
				</div>
			</div>
			<div id="details">
				<div id="jobs" class="labelGroup">
					<span class="label">current jobs</span>
					<?php
					for ( $i = 0; $i < count($jobs); $i++ ) {
						echo "<span>$jobs[$i]</span>";
						echo "<br>";
					}
					?>
				</div>
				<div id="address" class="labelGroup">
					<span class="label">address</span>
					<span><?php echo $streetName?></span>
					<span><?php echo $buildingNumber?></span>
					<span><?php echo $orientationNumber?></span>
					<span><?php echo $city?></span>
				</div>
				<div id="contactInfo" class="labelGroup">
					<span class="label">contact</span>
					<span><?php echo $phoneNumber?></span>
					<span><?php echo $email?></span>
					<a href="<?php echo $webpage?>">ikoronka.com</a>
				</div>
			</div>
			<div class="labelGroup">
				<span class="label">status</span>
				<p>
					<?php
					if ( $lookingForJob ) {
						echo "I am looking for a job.";
					} else {
						echo "I am not looking for a job.";
					}
					?>
				</p>
			</div>
		</div>
	</div>
</body>
</html>