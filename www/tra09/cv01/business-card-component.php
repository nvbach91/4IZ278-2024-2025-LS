<?php
$person = [
	'avatar' => 'https://via.placeholder.com/150',
	'lastName' => 'Smith',
	'firstName' => 'John',
	'dateOfBirth' => '1990-05-15',
	'occupation' => 'Web Developer',
	'company' => 'Tech Solutions Inc.',
	'street' => 'Silicon Avenue',
	'descriptiveNumber' => '42',
	'referenceNumber' => 'B-123',
	'city' => 'San Francisco',
	'phone' => '+1 (555) 123-4567',
	'email' => 'john.smith@example.com',
	'website' => 'www.johnsmith.dev',
	'lookingForJob' => false
];

// Calculate age from date of birth
function calculateAge($birthDate)
{
	$birth = new DateTime($birthDate);
	$today = new DateTime('today');
	$age = $birth->diff($today)->y;
	return $age;
}

$age = calculateAge($person['dateOfBirth']);
?>

<!-- Business Card Component -->
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

<div class="business-card">
	<div class="card-header">
		<img src="<?php echo $person['avatar']; ?>" alt="<?php echo $person['firstName'] . ' ' . $person['lastName']; ?>" class="avatar">
		<div class="name-section">
			<h1><?php echo $person['firstName'] . ' ' . $person['lastName']; ?></h1>
			<h2><?php echo $person['occupation']; ?></h2>
		</div>
	</div>

	<div class="card-body">
		<div class="info-group">
			<h3>Personal Information</h3>
			<div class="info-item">
				<div class="info-label">Full Name:</div>
				<div class="info-value"><?php echo $person['lastName'] . ' ' . $person['firstName']; ?></div>
			</div>
			<div class="info-item">
				<div class="info-label">Age:</div>
				<div class="info-value"><?php echo $age; ?> years</div>
			</div>
			<div class="info-item">
				<div class="info-label">Occupation:</div>
				<div class="info-value"><?php echo $person['occupation']; ?></div>
			</div>
			<div class="info-item">
				<div class="info-label">Company:</div>
				<div class="info-value"><?php echo $person['company']; ?></div>
			</div>
		</div>

		<div class="info-group">
			<h3>Address</h3>
			<div class="info-item">
				<div class="info-label">Street:</div>
				<div class="info-value"><?php echo $person['street']; ?></div>
			</div>
			<div class="info-item">
				<div class="info-label">Descriptive No.:</div>
				<div class="info-value"><?php echo $person['descriptiveNumber']; ?></div>
			</div>
			<div class="info-item">
				<div class="info-label">Reference No.:</div>
				<div class="info-value"><?php echo $person['referenceNumber']; ?></div>
			</div>
			<div class="info-item">
				<div class="info-label">City:</div>
				<div class="info-value"><?php echo $person['city']; ?></div>
			</div>
		</div>

		<div class="info-group">
			<h3>Contact Information</h3>
			<div class="info-item">
				<div class="info-label">Phone:</div>
				<div class="info-value contact-links">
					<a href="tel:<?php echo $person['phone']; ?>"><?php echo $person['phone']; ?></a>
				</div>
			</div>
			<div class="info-item">
				<div class="info-label">Email:</div>
				<div class="info-value contact-links">
					<a href="mailto:<?php echo $person['email']; ?>"><?php echo $person['email']; ?></a>
				</div>
			</div>
			<div class="info-item">
				<div class="info-label">Website:</div>
				<div class="info-value contact-links">
					<a href="https://<?php echo $person['website']; ?>" target="_blank"><?php echo $person['website']; ?></a>
				</div>
			</div>
		</div>

		<div class="job-status <?php echo $person['lookingForJob'] ? 'looking' : 'not-looking'; ?>">
			<?php echo $person['lookingForJob'] ? 'Currently Looking for Job Opportunities' : 'Not Currently Looking for Job Opportunities'; ?>
		</div>
	</div>
</div>
