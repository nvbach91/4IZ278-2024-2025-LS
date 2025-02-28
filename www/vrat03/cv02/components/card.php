<?php
require __DIR__.'/../classes/Person.php';

$people=[];

array_push($people, 
    new Person('Steve',
                'Jobs',
                'https://upload.wikimedia.org/wikipedia/commons/thumb/d/dc/Steve_Jobs_Headshot_2010-CROP_%28cropped_2%29.jpg/800px-Steve_Jobs_Headshot_2010-CROP_%28cropped_2%29.jpg',
                'https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg',
                1955,
                'CEO',
                'Apple Inc',
                1,
                'Apple Park Way',
                'Cupertino',
                'CA',
                95014,
                'United States',
                'ceo@apple.com',
                'www.apple.com',
                false));

array_push($people,
    new Person('Jakub',
                'Fischer',
                'https://fis.vse.cz/wp-content/uploads/Jakub-Fischer_600x600_acf_cropped.jpg',
                'https://pr.vse.cz/wp-content/uploads/page/58/FIS-cs-color.png',
                1978,
                'Dean',
                "FIS VŠE",
                4,
                'nám. W. Churchilla',
                'Praha 3 - Žižkov',
                '',
                13067,
                'Czechia',
                'fischerj@vse.cz',
                'www.fis.vse.cz',
                true));

array_push($people,
    new Person('Petr',
                'Dvořák',
                'https://www.vse.cz/wp-content/uploads/Petr-Dvorak_rektor_600x600_acf_cropped.jpg',
                'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQOZ5wqHDwJmadEuiE2KMffqxv39CRtWwRPOw&s',
                1960,
                'Rector',
                'VŠE',
                4,
                'nám. W. Churchilla',
                'Praha 3 - Žižkov',
                '',
                13067,
                'Czechia',
                'petr.dvorak@vse.cz',
                'www.vse.cz',
                false))


?>

<?php foreach($people as $person): ?>
    <div class="card">
        <div class="column">
            <img class="photo" src=<?php echo $person->photo; ?> alt="Profile picture">
            <div class="name"><?php echo $person->getFullName(); ?></div>
            <div class="age"><?php echo $person->getAge(); ?> years old</div>
            <div class="job"><?php echo $person->getFullJob(); ?></div>
            <div class="email">Email: <a href="mailto:<?php echo $person->email; ?>"> <?php echo $person->email; ?> </a></div>
            <div class="searchingEmployees"><?php echo $person->isSearchingEmployees(); ?></div>
        </div>
        <div class="column">
                
            <div class="adress">
                <div class="adressLine"><?php echo $person->getAddressLine(1); ?></div>
                <div class="adressLine"><?php echo $person->getAddressLine(2); ?></div>
                <div class="adressLine"><?php echo $person->getAddressLine(3); ?></div>
                <div class="adressLine"><?php echo $person->getAddressLine(4); ?></div>
            </div>
            <div class="web"><a href=<?php echo $person->web; ?>><?php echo $person->web; ?></a></div>
            <img class="logo" src=<?php echo $person->logo; ?> alt="Company logo">
        </div>
    </div>
<?php endforeach; ?>