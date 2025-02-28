
<?php
require '../cv02/classes/Person.php';

$people = [];
array_push($people, new Person(
    'Bateman',
    'Patrick',
    '27',
    'Vice President',
    'Pierce & Pierce',
    '358 Exchange place',
    '10099',
    'New York',
    '2125556342',
    'eso.vse.cz/~schd22/cv02/'
    )
    );
array_push($people, new Person(
    'Van Patten',
    'David',
    '30',
    'Vice President',
    'Pierce & Pierce',
    '361 Exchange place',
    '10099',
    'New York',
    '7524446452',
    'eso.vse.cz/~schd22/cv02/'
    )
    );
array_push($people, new Person(
    'Brycy',
    'Timothy',
    '25',
    'Vice President',
    'Pierce & Pierce',
    '124 Exchange place',
    '10099',
    'New York',
    '2485556342',
    'eso.vse.cz/~schd22/cv02/'
    )
    );
array_push($people, new Person(
    'Allen',
    'Paul',
    '28',
    'Vice President',
    'Pierce & Pierce',
    '781 Exchange place',
    '10099',
    'New York',
    '3135557841',
    'eso.vse.cz/~schd22/cv02/'
    )
    );
function formatPupulation($value) {
    return number_format($value, 0, '.', ' ');
}

?>

<?php foreach($people as $person): ?>
    <div class="whole">
    <div class="front">
        <div class="contact">
            <div class ="mobile"><?php echo formatPupulation($person->mobile); ?></div>
            <div class ="firm"><?php echo $person->firm; ?></div>
        </div>    
        <div class="header">
            <div class ="name"><?php echo $person->name;?></div>
            <div class ="lastName"><?php echo $person->lastName; ?></div>
            <div class ="job"><?php echo $person->job; ?></div>
        </div>
        <div class="place">
            <div class ="street"><?php echo $person->street; ?></div>
            <div class ="city"><?php echo $person->city; ?></div>
            <div class ="cityNumber"><?php echo $person->cityNumber; ?></div>
        </div>
    </div>
    <div class="back">
        <div class="firm">
            <div class ="web"><?php echo $person->web; ?></div>   
            <div class ="age"><?php echo 'Age: ' . $person->age; ?></div>
        </div>
    </div>
    </div>
<?php endforeach; ?>
