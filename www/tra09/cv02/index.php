<?php
require_once 'utils.php';
require_once 'Person.php';
include 'header.php';

// Create instances of Person class
$john = new Person(
	'https://via.placeholder.com/150',
	'Smith',
	'John',
	'1990-05-15',
	'Web Developer',
	'Tech Solutions Inc.',
	'Silicon Avenue',
	'42',
	'B-123',
	'San Francisco',
	'+1 (555) 123-4567',
	'john.smith@example.com',
	'www.johnsmith.dev',
	false
);

$sherlock = new Person(
	'https://via.placeholder.com/150',
	'Holmes',
	'Sherlock',
	'1854-01-06',
	'Consulting Detective',
	'221B Baker Street',
	'Baker Street',
	'221B',
	'',
	'London',
	'+44 20 7123 4567',
	'sherlock.holmes@bakerstreet.com',
	'www.sherlockholmes.com',
	true
);

$gandalf = new Person(
	'https://via.placeholder.com/150',
	'Grey',
	'Gandalf',
	'1000-01-01',
	'Wizard',
	'The Istari',
	'Middle-earth',
	'Various',
	'',
	'Valinor',
	'+1 (555) 999-8888',
	'gandalf@middleearth.com',
	'www.gandalf.com',
	false
);

$people = [$john, $sherlock, $gandalf];

foreach ($people as $person): ?>
	<div class="business-card">
		<div class="card-header">
			<img src="<?php echo $person->getAvatar(); ?>" alt="<?php echo $person->getFullName(); ?>" class="avatar">
			<div class="name-section">
				<h1><?php echo $person->getFullName(); ?></h1>
				<h2><?php echo $person->getOccupation(); ?></h2>
			</div>
		</div>

		<div class="card-body">
			<div class="info-group">
				<h3>Personal Information</h3>
				<div class="info-item">
					<div class="info-label">Full Name:</div>
					<div class="info-value"><?php echo $person->getFullName(); ?></div>
				</div>
				<div class="info-item">
					<div class="info-label">Age:</div>
					<div class="info-value"><?php echo $person->getAge(); ?> years</div>
				</div>
				<div class="info-item">
					<div class="info-label">Occupation:</div>
					<div class="info-value"><?php echo $person->getOccupation(); ?></div>
				</div>
				<div class="info-item">
					<div class="info-label">Company:</div>
					<div class="info-value"><?php echo $person->getCompany(); ?></div>
				</div>
			</div>

			<div class="info-group">
				<h3>Address</h3>
				<?php $address = $person->getAddress(); ?>
				<div class="info-item">
					<div class="info-label">Street:</div>
					<div class="info-value"><?php echo $address['street']; ?></div>
				</div>
				<div class="info-item">
					<div class="info-label">Descriptive No.:</div>
					<div class="info-value"><?php echo $address['descriptiveNumber']; ?></div>
				</div>
				<div class="info-item">
					<div class="info-label">Reference No.:</div>
					<div class="info-value"><?php echo $address['referenceNumber']; ?></div>
				</div>
				<div class="info-item">
					<div class="info-label">City:</div>
					<div class="info-value"><?php echo $address['city']; ?></div>
				</div>
			</div>

			<div class="info-group">
				<h3>Contact Information</h3>
				<?php $contact = $person->getContactInfo(); ?>
				<div class="info-item">
					<div class="info-label">Phone:</div>
					<div class="info-value contact-links">
						<a href="tel:<?php echo $contact['phone']; ?>"><?php echo $contact['phone']; ?></a>
					</div>
				</div>
				<div class="info-item">
					<div class="info-label">Email:</div>
					<div class="info-value contact-links">
						<a href="mailto:<?php echo $contact['email']; ?>"><?php echo $contact['email']; ?></a>
					</div>
				</div>
				<div class="info-item">
					<div class="info-label">Website:</div>
					<div class="info-value contact-links">
						<a href="https://<?php echo $contact['website']; ?>" target="_blank"><?php echo $contact['website']; ?></a>
					</div>
				</div>
			</div>

			<div class="job-status <?php echo $person->isLookingForJob() ? 'looking' : 'not-looking'; ?>">
				<?php echo $person->isLookingForJob() ? 'Currently Looking for Job Opportunities' : 'Not Currently Looking for Job Opportunities'; ?>
			</div>
		</div>
	</div>
<?php endforeach;

include 'footer.php';
