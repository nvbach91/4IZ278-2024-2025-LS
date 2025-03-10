<?php use classes\Person;

require __DIR__."/classes/Person.php";?>
<?php
$cities=[
        [
                "name" => "prague",
            "population" => 2_000_000
        ],
    [
        "name" => "warsaw",
        "population" => 3_000_000
    ]
];


function formatPopulation($value){
    $roundedValue = round($value);
return number_format($roundedValue, 0, '.', ' ');
}

$person1 = new Person("Peter","peter@email.com","123 456 789","New Street 13","0100","3843984393");
$person2 = new Person("Jan","jan@email.com","467 456 789","Old Street 55","5500","839839489");

$persons= [
        $person1, $person2];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>My cities</h1>
<ul>
    <?php foreach ($cities as $city): ?>
        <li>
            <div><?php echo $city["name"]; ?></div>
            <div><?php echo formatPopulation($city["population"]) ?></div>
        </li>
    <?php endforeach; ?>
</ul>
<h1>My buddies</h1>
<div>
    <?php foreach($persons as $person): ?>
        <div><?php echo $person->name;?></div>
        <div><?php echo $person->email;?></div>
        <div><strong><?php echo $person->getBankAccount();?></strong></div>
        <br>
    <?php endforeach; ?>
</div>
</body>
</html>