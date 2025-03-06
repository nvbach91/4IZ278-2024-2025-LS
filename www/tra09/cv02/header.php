<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Business Cards</title>
	<style>
		.business-card {
			width: 100%;
			max-width: 500px;
			background: linear-gradient(135deg, #ffffff 0%, #f3f3f3 100%);
			border-radius: 15px;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
			overflow: hidden;
			display: flex;
			flex-direction: column;
			transition: transform 0.3s ease, box-shadow 0.3s ease;
			margin: 30px auto;
		}

		.business-card:hover {
			transform: translateY(-5px);
			box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
		}

		.card-header {
			background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
			color: white;
			padding: 25px;
			display: flex;
			align-items: center;
		}

		.avatar {
			width: 100px;
			height: 100px;
			border-radius: 50%;
			object-fit: cover;
			border: 4px solid white;
			box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
		}

		.name-section {
			margin-left: 20px;
		}

		.name-section h1 {
			font-size: 24px;
			margin-bottom: 5px;
		}

		.name-section h2 {
			font-size: 18px;
			font-weight: normal;
			opacity: 0.9;
		}

		.card-body {
			padding: 25px;
		}

		.info-group {
			margin-bottom: 20px;
		}

		.info-group:last-child {
			margin-bottom: 0;
		}

		.info-group h3 {
			font-size: 16px;
			color: #3498db;
			margin-bottom: 10px;
			border-bottom: 1px solid #eee;
			padding-bottom: 5px;
		}

		.info-item {
			display: flex;
			margin-bottom: 8px;
		}

		.info-label {
			width: 140px;
			font-weight: bold;
			color: #555;
		}

		.info-value {
			flex: 1;
			color: #333;
		}

		.job-status {
			margin-top: 20px;
			padding: 10px;
			border-radius: 5px;
			text-align: center;
			font-weight: bold;
		}

		.looking {
			background-color: #e74c3c;
			color: white;
		}

		.not-looking {
			background-color: #2ecc71;
			color: white;
		}

		.contact-links a {
			color: #3498db;
			text-decoration: none;
			transition: color 0.2s ease;
		}

		.contact-links a:hover {
			color: #2980b9;
			text-decoration: underline;
		}

		@media (max-width: 500px) {
			.card-header {
				flex-direction: column;
				text-align: center;
			}

			.name-section {
				margin-left: 0;
				margin-top: 15px;
			}

			.info-item {
				flex-direction: column;
			}

			.info-label {
				width: 100%;
				margin-bottom: 3px;
			}
		}
	</style>
</head>

<body>
	<main>
