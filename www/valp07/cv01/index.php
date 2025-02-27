<?php
$company = 'Pierce & Pierce';
$logo = 'https://eso.vse.cz/~valp07/cv01/img/logo.svg';
$name = 'Patrick';
$surname = 'Bateman';
$phone = 2125556342;
$mail = 'bateman@pierce.com';
$webName = 'pierce.com';
$webSite = 'https://www.imdb.com/title/tt0144084/';
$position = 'Vice President';
$isSearching = false;
$birthYear = 2000;
$street = 'Exchange Place';
$streetNumber = 358;
$postalCode = 100099;
$city = 'New York';
$age = date('Y') - $birthYear;
$searchingStatus = $isSearching ? 'Looking for work' : 'Not looking for work';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Card</title>
    <link rel="stylesheet" href="./css/styles.css" />
</head>

<body>
    <div class="card">
        <header>
            <div>Phone: <?php echo $phone; ?></div>
            <div>E-Mail: <?php echo $mail; ?></div>
            <div class="right">
                <img src="<?php echo $logo; ?>" alt="company logo">
                <a href="<?php echo $webSite; ?>" target="_blank"><?php echo $webName; ?></a>
            </div>
        </header>
        <main>
            <h1><?php echo "$name $surname"; ?></h1>
            <h2><?php echo "$position - $company"; ?></h2>
            <h3><?php echo $searchingStatus; ?></h3>
        </main>
        <footer>
            <p><?php echo "$streetNumber $street, $postalCode, $city"; ?></p>
            <p>Age: <?php echo $age; ?></p>
        </footer>
    </div>
</body>

</html>

<!--
odevzdat PR podle návodu
klikatelné adresy atd
    Avatar nebo Logo
    Příjmení
    Jméno
    Věk (výpočet z datumu narození)
    Povolání nebo Pozice
    Název firmy
    Ulice
    Číslo popisné
    Číslo orientační
    Město
    Telefon
    E-mail
    Adresa webové stránky
    Zda sháníte práci (Boolean)