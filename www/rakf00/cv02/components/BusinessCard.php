<?php require __DIR__ . "/../classes/Person.php" ?>
<?php include __DIR__ . "/../utils.php" ?>
<?php
$persons = [];

array_push($persons,
    new Person("Jan", "Novák", new DateTime("2003-11-01"), "Programátor", "TechSoft", 777123456, "Javorová 12", "Praha", "jan.novak@example.com"),
    new Person("Petr", "Svoboda", new DateTime("2000-10-04"), "Grafik", "DesignPro", 606789123, "Lipová 8", "Brno", "petr.svoboda@example.com"),
    new Person("Eva", "Králová", new DateTime("1980-01-05"), "Účetní", "FinancePlus", 720456789, "Školní 5", "Ostrava", "eva.kralova@example.com")
);

?>

<?php foreach ($persons as $person): ?>
    <div class="container">
        <section><img src="../cv02/images/logo.png" alt="logo"></section>
        <section id="aboutMe">
            <h2> <?= $person->getFullName() ?></h2>
            <p><?= getAge($person->birthDate) ?> y/o</p>
            <p><?= $person->company ?></p>
            <address>
                <?= $person->getAddress() ?>
            </address>
            <div class="clickAble">
                <a href="<?php echo "tel:+420" . $person->phone; ?>"><?php echo "+420 " . number_format($person->phone, "0", "", " ") ?></a>
                <a href="mailto:<?php echo $person->email ?>"><?php echo $person->email ?></a>
                <a id="website" href="" target="_blank">WEB</a>
            </div>
        </section>
    </div>
<?php endforeach; ?>