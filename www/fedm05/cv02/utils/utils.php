<?php
require __DIR__ . '/../' . 'classes/Person.php';
$people_list = [];

array_push($people_list, new Person(
    "Martin Fedorík",
    "Data Scientist",
    "DSolutions s.r.o.",
    new DateTime("2001-10-01"),
    "nám. Winstona Churchilla",
    4,
    1938,
    "120 00",
    "Praha 3-Žižkov",
    "+420123123123",
    "martinfedorik@seznam.cz",
    "https://www.martinfedorik.com",
    False,
    "Machine Learning • Optimization • Automation"
));

array_push($people_list, new Person(
    "Honza Debian",
    "Linux Architect",
    "DSolutions s.r.o.",
    new DateTime("1995-05-01"),
    "Jeseniova",
    4,
    1954,
    "130 00",
    "Praha 3-Žižkov",
    "+420999999999",
    "honzadebiank@seznam.cz",
    "https://www.honzadebian.com",
    True,
    "Linux • Docker • Scripting"
));

array_push($people_list, new Person(
    "David Kebal",
    "DevOps Engineer",
    "DSolutions s.r.o.",
    new DateTime("1990-01-01"),
    "Chemická",
    3,
    955,
    "120 00",
    "Praha 4",
    "+420111111111",
    "davidkebal@seznam.cz",
    "https://www.davidkebal.com",
    True,
    "Kubernetes • CI/CD • Cloud"
));

?>

<div class="cards">
    <?php foreach ($people_list as $person): ?>
        <div class="card-container">
            <div class="card front">
                <div class="logo-container">
                    <img src="img/logo.png" alt="Company Logo" class="logo">
                </div>
                <div class="card-content">
                    <div class="name"><?php echo $person->name; ?></div>
                    <div class="title"><?php echo $person->title; ?></div>
                    <div class="company"><?php echo $person->company; ?></div>
                    <div class="contact-info">
                        <ul>
                            <li>
                                <i class="fas fa-birthday-cake"></i><?php echo $person->calculateAge(); ?>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <a class="mail" href="mailto:<?php echo $person->email; ?>"><?php echo $person->email ?></a>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <a class="phone" href="tel:<?php echo $person->phone; ?>"><?php echo $person->phone ?></a>
                            </li>
                            <li>
                                <i class="fas fa-globe"></i>
                                <a class="website" href="<?php echo $person->website; ?>"><?php echo $person->website ?></a>
                            </li>
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <?php echo $person->getCompleteAddress(); ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card back">
                <div class="name-back"><?php echo $person->name; ?></div>
                <div class="work-indicator">
                    <?php echo $person->lookingForWork(); ?>
                </div>
                <div class="divider"></div>
                <div class="expertise"><?php echo $person->expertise; ?></div>
            </div>
        </div>
    <?php endforeach ?>
</div>