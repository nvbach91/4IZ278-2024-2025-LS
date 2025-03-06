<?php
require './classes/Person.php';


$people = [];
array_push($people, new Person(
    'Din',
    'Djarin',
    'Bounty hunter',
    'Mandalorians',
    'Mandalore',
    'Outer Rim',
    '+420 111111111',
    'Diny@djaring.com',
    'www.starwars.com',
    'https://pngimg.com/d/mandalorian_PNG23.png',
    false,
    '1983/02/02',
    'https://cdn.thisiswhyimbroke.com/images/Life-Sized-Razor-Crest-640x533.jpg'
));

array_push($people, new Person(
    'Ahsoka',
    'Tano',
    'Jedi',
    'Jedi Order',
    'Shili',
    'Outer Rim',
    '+420 111111111',
    'Ahsoka@Tano.com',
    'www.starwars.com',
    'https://dokina.timg.cz/2023/04/11/1482535-star-wars-ahsoka-base_16x9.jpg.653?1681197720.0',
    true,
    '1983/02/02',
    'https://dokina.timg.cz/2022/05/10/1379232-star-wars-ahsoka-base_16x9.jpg.653?1652174253.0'
));

array_push($people, new Person(
    'Boba',
    'Fett',
    'Bounty hunter',
    'Clones',
    'Kamino',
    'Rishi Maze',
    '+420 111111111',
    'Boba@Fett.com',
    'www.starwars.com',
    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTXNqq44vDaMMexbY-w30YPHwzRFcYVMePa3A&s',
    false,
    '1983/02/02',
    './pictures/imageedit_1_4757775577.jpg'
));
?>


<h1 class="title">Business Card in PHP</h1>
<?php foreach ($people as $person): ?>
    <div class="business-card-front">
        <div class="Avatar">
            <div class="logo-div"><img class='logo' src="<?php echo $person->avatar ?>" alt="Avatar"></div>
        </div>
        <div class="info">
            <div class="firstname"><?php echo $person->name ?></div>
            <div class="lastname"><?php echo $person->surname ?></div>
            <div class="positions">
                <div class="position"><?php echo $person->position ?></div>
                <div class="company"><?php echo $person->company ?></div>
            </div>
        </div>
    </div>
    <div class="business-card-back">
        <div class="info">
            <div class="firstname"><?php echo $person->name ?></div>
            <div class="lastname"><?php echo $person->surname ?></div>
            <div class="position"><?php echo $person->position ?></div>
            <div class="age">age: <?php echo $person->getAge() ?></div>
        </div>
        <div class="contacts">
            <div><img class="icon" src="https://www.svgrepo.com/show/27276/planet.svg" alt="">
                <div class="address"> <?php echo $person->planet; ?></div>
            </div>
            <div><img class="icon" src="https://www.iconpacks.net/icons/1/free-phone-icon-504-thumb.png" alt="">
                <div class="phone"><a href="tel:+420111111111"><?php echo $person->phoneNumber ?></a></div>
            </div>
            <div><img class="icon" src="https://www.svgrepo.com/show/14478/email.svg" alt="">
                <div class="email"> <a href="mailto:veslovani@bohemianstj.cz"><?php echo $person->email ?></a></div>
            </div>
            <div><img class="icon" src="https://www.svgrepo.com/show/197996/internet.svg" alt="">
                <div class="website"> <a href="www.starwars.com"><?php echo $person->web ?></a></div>
            </div>
        </div>
        <img class="background" src="<?php echo $person->background ?>" alt="backgound">
    </div>
<?php endforeach; ?>