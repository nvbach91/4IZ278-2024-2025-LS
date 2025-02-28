
<?php require __DIR__ . '/classes/Person.php'; ?>
<?php

$cities = [
    [
        'name' => 'Prague',
        'population' => 2_000_000,
    ],
    [
        'name' => 'Warsaw',
        'population' => 2_000_000,
    ],
    [
        'name' => 'Moscow',
        'population' => 2_000_000,
    ],
    [
        'name' => 'London',
        'population' => 2_000_000,
    ],
    [
        'name' => 'Paris',
        'population' => 2_000_000,
    ],
];

function formatPopulation($value) {
    // $roundedValue = round($value);
    return number_format($value, 0, '.', ' ');
}

$person1 = new Person(
    'David',
    'david@beckham.com',
    '321 654 987',
    'Address 1, City 2, State 3',
    '0100',
    '222333444',
);

$person2 = new Person(
    'Ronaldo',
    'ronaldo@ronaldo.com',
    '987 654 321',
    'Address 4, City 5, State 6',
    '0800',
    '666777888',
);

$persons = [$person1, $person2];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>My cities</h1>
    <ul>
        <?php foreach($cities as $city): ?>
        <li>
            <div><?php echo $city['name']; ?></div>
            <div>Population: <?php echo formatPopulation($city['population']); ?></div>
        </li>
        <?php endforeach; ?>
    </ul>
    <h2>My buddy</h2>
    <div>
        <?php foreach($persons as $person): ?>
        <div><?php echo $person->name; ?></div>
        <div><?php echo $person->email; ?></div>
        <div><?php echo $person->getFullBankAccountNumber(); ?></div>
        <?php endforeach; ?>
    </div>
</body>
</html>