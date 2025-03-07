<?php require __DIR__ . '/../classes/person.php' ?>
<?php 

$person1 = new Person(
    "Andrej",
    "Gončarov",
    "./resources/avatar.jpg",
    new DateTime("2003-12-30"),
    "Student VŠE FIS",
    "Grafická 950/22",
    "Praha 5",
    "150 00",
    "+420604354852",
    "gona11@vse.cz",
    1,
    "AndyGoncy",
    "AndyTheDev"
);

$person2 = new Person(
    "Petr",
    "Metr",
    "./resources/petr.jpg",
    new DateTime("1995-08-22"),
    "Senior Java Developer",
    "Lazarská 145",
    "Praha 1",
    "110 00",
    "+420736214471",
    "petrik@metrik.cz",
    1,
    "PetrMaMetr",
    "Petr3.28foot"
);

$person3 = new Person(
    "Bořislav",
    "Šťáhlavský",
    "./resources/borislav.jpg",
    new DateTime("1998-02-14"),
    "Medior Web Developer",
    "Na návsi 35",
    "Brno",
    "220 00",
    "+420605222144",
    "stahlavsky@zborek.cz",
    0,
    "Borik447",
    "WebStaBor"
);

$people = [$person1, $person2, $person3];

?>

        <div class="align_all_cards">
        <?php foreach ($people as $person):?>
            <div class="align_card">
                <div class="box box_front">
                    <div class="align_left">
                        <img class="avatar" src="<?php echo $person->avatar; ?>" alt="" srcset="">
                    </div>

                    <div class="align_right">
                        <div class="background_right"></div>
                        <div class="right_top">
                            <h1><?php echo $person->first_name;?></h1>
                            <h1><?php echo $person->last_name;?></h1>
                            <p><?php echo $person->getInfo();?></p>
                        </div>
                        <div class="right_bottom">
                            <div class="info_inline">
                                <span class="material-symbols-outlined">call</span>
                                <p><?php echo $person->phone;?></p>
                            </div>

                            <div class="info_inline">
                                <span class="material-symbols-outlined">mail</span>
                                <p><?php echo $person->email?></p>
                            </div>
                        
                            <div class="info_inline">
                                <span class="material-symbols-outlined">home</span>
                                <p><?php echo $person->adress?></p>
                            </div>

                            <div class="info_inline">
                                <span class="material-symbols-outlined">location_city</span>
                                <p><?php echo $person->getCityCode();?></p>
                            </div>
                            
                            <p><?php echo $person->seekingJob()?></p>
                        </div>
                    </div>
                </div>

                <div class="box box_back">
                    <h1><?php echo $person->getFullName()?></h1>
                    <div class="divider"></div>
                    <div class="info_inline">
                        <img class="logo" src="./resources/instagram.png" alt="" srcset="">
                        <p><?php echo $person->instagram?></p>
                    </div>
                    <div class="info_inline">
                        <img class="logo" src="./resources/github.png" alt="">
                        <p><?php echo $person->github?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?> 
        </div>
        