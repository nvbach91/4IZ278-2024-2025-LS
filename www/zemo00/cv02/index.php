<?php require __DIR__ . "/classes/Person.php";?>
<?php require __DIR__ . "/utilities/utils.php";?>

<?php

$persons = [];

$person1 = new Person(
    "images/fis.png",
    "vse",
    ["Ondřej", "Žemlička"],
    "2003-08-23",
    "Student",
    "VŠE",
    [
        "street" => "Pražská",
        "street_num" => 500,
        "orientation_num" => 20,
        "zip" => "110 00",
        "city" => "Prague",
        "state" => "ČR"
    ],
    [
        "phone" => "536 982 451",
        "email" => "ondrejzemlicka@gmail.com",
        "website" => "ondrejzemlicka.com"
    ],
    false
);

array_push($persons, $person1);

$person2 = new Person(
    "images/mythosaur.png",
    "galactic",
    ["Jango", "Fett"],
    "1984-01-01",
    "Bounty hunter",
    "Kamino Cloning",
    [
        "street" => "Ocean Lane",
        "street_num" => 501,
        "orientation_num" => 66,
        "zip" => "00099",
        "city" => "Tipoca City",
        "state" => "Kamino"
    ],
    [
        "phone" => "758 236 951",
        "email" => "jango.fett@mandalore.com",
        "website" => "jangofett.com"
    ],
    true
);
array_push($persons, $person2);

$person3 = new Person(
    "images/suit.png",
    "classic",
    ["Patrick", "Bateman"],
    "1977-01-01",
    "Vice President",
    "Pierce & Pierce",
    [
        "street" => "Exchange Place",
        "street_num" => 358,
        "orientation_num" => 89,
        "zip" => "10099",
        "city" => "New York",
        "state" => "NY"
    ],
    [
        "phone" => "212 555 634",
        "email" => "patrickbateman@pnp.com",
        "website" => "patrickbateman.com"
    ],
    false
);

array_push($persons, $person3)

?>

<?php include __DIR__ . "/includes/head.html";?>


<div>
    <?php foreach($persons as $person): ?>
    <div class="<?php echo $person->style . ' cards'; ?>"> <!-- card -->
        <div class="card"> <!-- front -->
            <img src=<?php echo $person->image; ?> alt="">
            <div class="name"> <?php echo $person->getFullName(); ?> </div>
            <div class="position"> <?php echo $person->getPositionAtCompany(); ?> </div>
        </div>
        <div class="card container"><!-- back -->
            <div>
                <p><?php echo $person->getFullAddress(); ?></p>
                <p><?php echo getAge($person->dob);?></p>
            </div>
            <div>
                <p>
                    <span><?php echo $person->contact["phone"]; ?></span> <br>
                    <span><?php echo $person->contact["email"]; ?></span>
                </p>
                <a href="<?php echo $person->contact["website"]; ?>"><?php echo $person->contact["website"];?></a>
                <p><?php echo $person->getWorkMessage(); ?></p>
            </div>
        </div>
    </div>

    <?php endforeach; ?>
</div>




<?php include __DIR__ . "/includes/foot.html";?>