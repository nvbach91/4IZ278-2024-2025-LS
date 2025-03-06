
    <main class="container">
<?php
require './classes/Person.php';
    $people = [];

    array_push($people, new Person("Jakub", "Adam", "Developer", "Microsoft", 
                                    "Hlavní", "123", "", "Praha", 
                                    "+420700600500", "jakub@adam.com", "jakub.adam.cz", 
                                    "2002-10-28", "avatar1.webp", "logo1.png", true));

    array_push($people, new Person("Franta", "Flinta", "Designer", "IBM", 
                                    "Květnová", "456", "A", "Brno", 
                                    "+420600700800", "franta@flinta.com", "franta.flinta.cz", 
                                    "1985-05-15", "avatar2.png", "logo2.webp", false));

    array_push($people, new Person("Petr", "Svoboda", "Manager", "Facebook-Meta", 
                                    "Jarní", "789", "B", "Ostrava", 
                                    "+420500600700", "petr@svoboda.com", "petr.svoboda.cz", 
                                    "1992-03-20", "avatar3.png", "logo3.webp", true));
    ?>

    <?php foreach ($people as $person): ?>
        <div class="cardos row">
            <div class="col-sm-6">
                <img src="./images/<?php echo $person->avatar; ?>" alt="<?php echo $person->nameFirst . ' ' . $person->nameLast; ?> avatar">
            </div>

            <div class="col-sm-6 upper-text">
                <p class="name"><?php echo getFullName($person); ?></p>
                <p class="profession"><?php echo $person->profession; ?></p>
                <p class="company">Ve společnosti <?php echo $person->nameCompany; ?></p>
                <p class="year">Věk: <?php echo getAge($person); ?> let</p>
            </div>
        </div>
        <div class="cardos row">
            <div class="col-sm-6">
            <img src="./images/<?php echo $person->logo; ?>" alt="<?php echo $person->nameFirst . ' ' . $person->nameLast; ?> logo společnosti">
            </div>

            <div class="col-sm-6 down-text">
                <p class="address"><i class="fas fa-map-marker-alt"></i> <?php echo getAddress($person); ?></p>
                <p class="telephone"><i class="fas fa-phone"></i> <a href="tel:<?php echo $person->telephone; ?>"><?php echo $person->telephone; ?></a></p>
                <p class="email"><i class="fas fa-at"></i> <a href="mailto:<?php echo $person->email; ?>"><?php echo $person->email; ?></a></p>
                <p class="web"><i class="fas fa-globe"></i> <a href="<?php echo $person->web; ?>" target="blank"><?php echo $person->web; ?></a></p>
                <p class="available"><i><?php echo $person->available ? "Nyní jsem k dispozici" : "Nyní nejsem k dispozici"; ?></i></p>
            </div>
        </div>
    <?php endforeach; ?>
    </main>