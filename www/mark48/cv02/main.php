<?php
require "classes/Person.php";
require "classes/Address.php";



$address_1 = new Address("Ulice", "Město", "12345", "Česká Republika", "123");
$address_2 = new Address("Ulička", "Louny", "25225", "Česká Republika", "20");

$personal_card = new Person("Kryštof", "Marval", "1999-12-12", "Testovací Firmička", "+420 123 456 789", "marval.krystof@seznam.cz", "velice motivující slogan.", "Janitor", "https://github.com/marvalkrystof", $address_1);

$friend_1_card = new Person("Alexander", "Vedurnikof", "1991-12-10", "Testovací Firmička Nová", "+420 123 456 789", "vedurnikof@gmail.com", "sloganek vedurnikof", "Chief Janitor", "https://www.youtube.com/watch?v=dQw4w9WgXcQ", $address_2);
$friend_2_card = new Person("Ježíš", "Kristus", "1990-01-01", "Heaven s.r.o", "+420 123 456 789", "jezis@gmail.com", "Božský chlapec", "Chief", "https://www.youtube.com/watch?v=dQw4w9WgXcQ", $address_1);


$cards = [$personal_card, $friend_1_card, $friend_2_card];

?>

<main>
    <?php foreach ($cards as $card): ?>
        <div class="card front-card">
            <div class="card-centered-box">
                <div class="card-header">
                    <h1 class="card-front-text"><?php echo $card->company_name ?></h1>
                    <p class="card-front-text undertext"><?php echo $card->slogan ?></p>
                </div>
            </div>
        </div>

        <div class="card back-card">
            <div class="back-card-main-body">
                <h2 class="card-back-text"><?php echo $card->getFullName() ?></h1>
                    <p class="card-back-text undertext"><?php echo $card->job . " • " . $card->lookingForWorkString($card->job) ?></p>
                    <div class="splitter">
                    </div>
                    <div class="person-property-container">
                        <div class="icon-container">
                            <img src="imgs/person.svg">
                        </div>
                        <p class="card-back-text person-property-text"><?php echo $card->calculateAge($card->dob) . " years" ?></p>
                    </div>
                    <div class="person-property-container">
                        <div class="icon-container">
                            <img src="imgs/phone.svg">
                        </div>
                        <p class="card-back-text person-property-text"><?php echo $card->phone_number ?></p>
                    </div>
                    <div class="person-property-container">
                        <div class="icon-container">
                            <img src="imgs/envelope.svg">
                        </div>
                        <p class="card-back-text person-property-text"><?php echo $card->email ?></p>
                    </div>
                    <?php $card->web_page ?>
                    <div class="person-property-container">
                        <div class="icon-container">
                            <img src="imgs/web.svg">
                        </div>
                        <p class="card-back-text person-property-text">Web</p>
                    </div>
                    </a>
                    <div class="person-property-container">
                        <div class="icon-container">
                            <img src="imgs/building.svg">
                        </div>
                        <p class="card-back-text person-property-text"><?php echo $card->address ?></p>
                    </div>

            </div>
        <?php endforeach ?>


</main>