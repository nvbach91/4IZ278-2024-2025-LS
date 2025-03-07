<?php

require './classes/Person.php';

$people = [];

array_push($people, new Person(
    './img/oh.png',
    'Ivo',
    'Vejmelka',
    'Student',
    'VŠE',
    'Pražská',
    21,
    1,
    'Praha',
    '+420 725 876 005',
    'ivo.vejmelka@mailinator.com',
    'https://eso.vse.cz/~veji03/cv01/',
    false,
    '2002-08-22',
));

array_push($people, new Person(
    './img/oh2.png',
    'Tonda',
    'Vopršálek',
    'Člověk',
    'EŠV',
    'Někde',
    15,
    2,
    'Brno',
    '+420 987 654 321',
    'vopršálektonda@mailinator.com',
    'https://eso.vse.cz/~veji03/cv02/',
    true,
    '1998-12-20',
));

array_push($people, new Person(
    './img/oh3.png',
    'Franta',
    'Flinta',
    'Skoro Člověk',
    'Země',
    'Kdovíkde',
    99,
    3,
    'Ostrava',
    '+420 123 456 789',
    'franta.flinta@mailinator.com',
    'https://eso.vse.cz/~veji03/cv02a/',
    false,
    '2000-01-09',
));

?>


<?php foreach ($people as $person) : ?>
    <div class="fullCard">
        <div class="business-card front row">
            <div class="logoDiv col-sm-6">
                <img class="logo" src="<?php echo $person->avatar; ?>">
            </div>
            <div class="frontText col-sm-6">
                <div class="frontName">    
                    <div class="firstname"><?php echo $person->firstName; ?></div>
                    <div class="lastname"><?php echo $person->lastName; ?></div>
                </div>
                <div class="frontInfo">
                    <div>Pozice: <?php echo $person->ocupation; ?></div>
                    <div>Společnost: <?php echo $person->company; ?></div>
                    <div>Věk: <?php echo $person->getAge(); ?> let</div>
                </div>
            </div>
        </div>
        <div class="business-card back row">
            <div class="backTop">  

                    <div class="firstname"><?php echo $person->getFullName(); ?></div>

            </div>
            <div class="contacts">
                
                    <div class="address"><i class="fas fa-map-marker-alt"></i> <?php echo $person->getAddress(); ?></div>
                    <div><i class="fas fa-phone"></i><a href="tel:<?php echo $person->phone; ?>"><?php echo $person->phone; ?></a></div>
                    <div><i class="fas fa-at"></i> <a href="mailto:<?php echo $person->email; ?>"><?php echo $person->email; ?></a></div>
                    <div><i class="fas fa-globe"></i> <a href="<?php echo $person->website; ?>"><?php echo $person->website; ?></a></div>
                    <div class="available"><?php echo $person->available ? 'Nyní nepřijímám nabídky' : 'Přijímám nabídky'; ?></div>
                
            </div>
        </div>
    </div>
<?php endforeach; ?>    


