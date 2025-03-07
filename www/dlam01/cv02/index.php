<?php require __DIR__ . "/classes/Person.php"; ?>
<?php

$saulGoodman = new Person(
    "Saul",
    "Goodman",
    "Criminal defense/Elder law",
    "12.11.1960",
    "+420 960 123 456",
    "SaulGoodman@gmail.com",
    "www.bettercallsaul.com",
    "https://www.bettercallsaul.com",
    "https://upload.wikimedia.org/wikipedia/en/thumb/8/8a/Better_Call_Saul_logo.svg/1200px-Better_Call_Saul_logo.svg.png",
    "9800 Montgomery Blvd NE",
    "Albuquerque",
    "In legal trouble?",
    "Better call Saul!"
);

$pepa = new Person(
    "Kim",
    "Wexler",
    "Attorney",
    "13.2.1968",
    "+420 950 123 456",
    "KimWexler@gmail.com",
    "www.kimwexler.com",
    "https://www.kimwexler.com",
    "icons/wm-logo.png",
    "6311 Montaño Rd NW",
    "Albuquerque",
    "Justice Matters Most",
    "Available for hire"
);

$persons = [$saulGoodman, $pepa];
?>
<?php include __DIR__ . "/includes/header.php"; ?>
<h1>Business card</h1>
<?php require __DIR__ . "/business_card.php"; ?>
<?php include __DIR__ . "/includes/footer.php"; ?>
