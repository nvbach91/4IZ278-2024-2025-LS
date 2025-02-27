<?php
// PHP initialization code
$pageTitle = "Hong Anh Tranová";
$currentYear = date("Y");

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?php echo $pageTitle; ?></title>
	<style>
		body {
			font-family: Arial, sans-serif;
			line-height: 1.6;
			margin: 0;
			padding: 20px;
			max-width: 800px;
			margin: 0 auto;
		}

		header,
		footer {
			background-color: #f4f4f4;
			padding: 20px;
			text-align: center;
			margin-bottom: 20px;
		}

		main {
			padding: 20px 0;
		}

		footer {
			margin-top: 20px;
		}

		.section-title {
			text-align: center;
			margin: 40px 0 20px;
			color: #333;
			border-bottom: 2px solid #3498db;
			padding-bottom: 10px;
		}
	</style>
</head>

<body>
	<header>
		<h1>Welcome to <?php echo $pageTitle; ?></h1>
		<p>A simple PHP template with HTML5</p>
		<p>Today is: <?php echo date("F j, Y"); ?></p>
	</header>

	<main>
		<h2 class="section-title">Business Card</h2>

		<?php include 'business-card-component.php'; ?>
	</main>

	<footer>
		<p>&copy; <?php echo $currentYear; ?> <?php echo $pageTitle; ?>. All rights reserved.</p>
		<p>Server time: <?php echo date("H:i:s"); ?></p>
	</footer>

	<!-- JavaScript can be added here -->
	<script>
		// Your JavaScript code goes here
		console.log("PHP template loaded!");
	</script>
</body>

</html>
