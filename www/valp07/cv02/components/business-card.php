<?php
require './classes/Person.php';

$people = [];

array_push($people, new Person(
    "https://eso.vse.cz/~valp07/cv01/img/logo.svg",
    "Patrick",
    "Bateman",
    "Vice President",
    "Pierce & Pierce",
    false,
    "212-555-6342",
    "patrick.bateman@pierceandpierce.com",
    "Pierce & Pierce",
    "https://www.pierceandpierce.com",
    "Wall Street",
    "358",
    "10005",
    "New York",
    "2000"
));
array_push($people, new Person(
    "https://eso.vse.cz/~valp07/cv01/img/logo.svg",
    "Paul",
    "Allen",
    "Vice President",
    "Pierce & Pierce",
    false,
    "212-555-9762",
    "paul.allen@pierceandpierce.com",
    "Pierce & Pierce",
    "https://www.imdb.com/title/tt0144084/characters/nm0001467/?ref_=tt_cst_c_9",
    "Lexington Avenue",
    "436",
    "10017",
    "New York",
    "1999"
));

array_push($people, new Person(
    "https://eso.vse.cz/~valp07/cv01/img/logo.svg",
    "Timothy",
    "Bryce",
    "Vice President",
    "Pierce & Pierce",
    true,
    "212-555-8234",
    "timothy.bryce@pierceandpierce.com",
    "Pierce & Pierce",
    "https://www.imdb.com/title/tt0144084/characters/nm0857620/?ref_=tt_cst_c_2",
    "Madison Avenue",
    "375",
    "10022",
    "New York",
    "1997"
));
?>
<?php foreach($people as $person): ?>
    <div class="card">
    <header>
        <div>Phone: <?php echo $person->phone; ?></div>
        <div>E-Mail: <?php echo $person->email; ?></div>
        <div class="right">
            <img src="<?php echo $person->logo; ?>" alt="company logo">
            <a href="<?php echo $person->webUrl; ?>" target="_blank"><?php echo $person->webName; ?></a>
        </div>
    </header>
    <section>
        <h1><?php echo $person->getFullName(); ?></h1>
        <h2><?php echo "$person->position - $person->company"; ?></h2>
        <h3><?php echo $person->getAvailability(); ?></h3>
    </section>
    <footer>
        <p><?php echo $person->getAddress(); ?></p>
        <p>Age: <?php echo $person->getAge(); ?></p>
    </footer>
</div>
<?php endforeach; ?>