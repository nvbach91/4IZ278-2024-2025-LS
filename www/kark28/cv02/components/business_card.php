<?php 
require './classes/Person.php';

$people = [];

array_push($people, new Person(
    'Kateřina', 
    'Karásková', 
    'katerina.karaskova@siemens.com', 
    '+420123123123', 
    '6.6.2003',
    'Siemens', 
    'Siemensova', 
    '2730', 
    '1', 
    'Prague', 
    'siemens.com', 
    'Working student', 
    'Web Content Support'
    )
);

array_push($people, new Person(
    'Maxicek', 
    'Cicimnau', 
    'maxicek.cicimnau@siemens.com', 
    '+420123123123', 
    '20.4.2019',
    'Siemens', 
    'Siemensova', 
    '2730', 
    '1', 
    'Prague', 
    'siemens.com', 
    'CEO', 
    'Company owner'
    )
);

array_push($people, new Person(
    'Pixinka', 
    'Pixinkova', 
    'pixinka.pixinkova@siemens.com', 
    '+420123123123', 
    '23.11.2019',
    'Siemens', 
    'Siemensova', 
    '2730', 
    '1', 
    'Prague', 
    'siemens.com', 
    'Secretary', 
    'Right hand of CEO'
    )
);
foreach($people as $person):?>
    <div class="card">
        <img src="assets/Siemens_AG_logo.svg" alt="Siemens logo">
    </div>
    <div class="card">
        <h1> <?php echo $person->getFullName();
        
        ?> </h1>
        <p id="age"><?php echo $person->getAge(); ?></p>
        <p id="position">
            <?php
                echo $person->position . " | " . $person->work;
             ?></p>
            <hr>
        <div class="contact">
            <p><a href=mailto:<?php echo $person->email; ?>><i class="fa-solid fa-at"></i> <?php echo $person->email; ?></a></p>
            <p><i class="fa-solid fa-phone-flip"></i> <?php echo $person->phone; ?></p>
            <p><a href=<?php echo $person->website; ?>><i class="fa-solid fa-globe"></i> <?php echo $person->website; ?></a></p>
        </div>
        <div class="address">
            <p><?php echo $person->company ?></p>
        <p><?php echo $person->getAddress(); ?></p>
            <p><?php echo $person->city ?></p>
        </div>
        </div>

<?php endforeach; ?>