<?php
require_once 'Person.php';

$person1 = new Person(
    "Jan", "Novak", "2000-01-01", "Web Developer", "Novak Webs sro",
    "Hlavni ulice", "1234", "5", "Praha", "+420 123 456 789",
    "email@email.com", "https://www.jannovakuvweb.com",
    true, "icons/icon1.png"
);

$person2 = new Person(
    "Frantisek", "Svoboda", "1995-05-15", "Graphic Designer", "Designer Studio sro",
    "Vedlejší ulice", "456", "7", "Brno", "+420 987 654 321",
    "frantasvobodu@seznam.com", "https://www.webfrantiskasvobody.com",
    false, "icons/icon2.png"
);

$person3 = new Person(
    "Pepa", "Novotny", "1988-11-23", "Software Engineer", "Software Masters sro",
    "Zadní ulice", "89", "10", "Ostrava", "+420 111 222 333",
    "nejlepsisoftengineer@petrdvorak.com", "https://www.petrdvorak.com",
    true, "icons/icon3.png"
);

$persons = [$person1, $person2, $person3];

include 'header.php';
?>

<main>
  <?php foreach ($persons as $person): ?>
    <div class="cards">

      <div class="card">
        <img src="<?php echo $person->getPicture(); ?>" alt="Foto <?php echo $person->getFullName(); ?>">
        <h1><?php echo $person->getFullName(); ?></h1>
        <p>Age: <?php echo $person->getAge(); ?></p>
        <p><?php echo $person->getJob(); ?></p>
      </div>

      <div class="card">
        <p><strong><?php echo $person->getCompany(); ?></strong></p>
        <p><?php echo $person->getAddress(); ?></p>
        <p>Tel: <?php echo $person->getPhone(); ?></p>
        <p>E-mail: <?php echo $person->getEmail(); ?></p>
        <p>Web: <?php echo $person->getWebsite(); ?></p>
        <p>Looking for job: <?php echo $person->getLookingForJobText(); ?></p>
      </div>

    </div>
  <?php endforeach; ?>
</main>

<?php include 'footer.php'; ?>
