<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


class Person
{
    public $first_name;
    public $last_name;
    public $dob;
    public $company_name;
    public $phone_number;
    public $email;
    public $slogan;
    public $job;
    public $web_page;
    public $address;

    public function __construct(
        $first_name,
        $last_name,
        $dob,
        $company_name,
        $phone_number,
        $email,
        $slogan,
        $job,
        $web_page,
        $address
    ) {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->dob = $dob;
        $this->company_name = $company_name;
        $this->phone_number = $phone_number;
        $this->email = $email;
        $this->slogan = $slogan;
        $this->job = $job;
        $this->web_page = $web_page;
        $this->address = $address;
    }

    public function getFullName()
    {
        return "$this->first_name $this->last_name";
    }
    function calculateAge()
    {
        $dob_obj = new DateTime($this->dob);
        $now = new DateTime();
        $difference = $now->diff($dob_obj);
        return $difference->y;
    }

    function lookingForWorkString()
    {
        if ($this->job == Null) {
            return "Looking for work";
        } else {
            return "Not looking for work";
        }
    }
}

class Address
{
    public $street;
    public $house_number;
    public $city;
    public $zip;
    public $country;

    public function __construct($street, $city, $zip, $country, $house_number)
    {
        $this->street = $street;
        $this->house_number = $house_number;
        $this->city = $city;
        $this->zip = $zip;
        $this->country = $country;
    }
    public function __toString()
    {
        return "$this->street $this->house_number, $this->city, $this->zip, $this->country";
    }
}




$address = new Address("Ulice", "Město", "12345", "Česká Republika", "123");
$personal_card = new Person("Kryštof", "Marval", "1999-12-12", "Testovací Firmička", "+420 123 456 789", "marval.krystof@seznam.cz", "velice motivující slogan.", "Janitor", "https://github.com/marvalkrystof", $address);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/card.css">
    <title>Personal Card</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div id="front-card" class="card">
        <div class="card-centered-box">
            <div class="card-header">
                <h1 class="card-front-text"><?php echo $personal_card->company_name ?></h1>
                <p class="card-front-text undertext"><?php echo $personal_card->slogan ?></p>
            </div>
        </div>
    </div>

    <div id="back-card" class="card">
        <div class="back-card-main-body">
            <h2 class="card-back-text"><?php echo $personal_card->getFullName() ?></h1>
                <p class="card-back-text undertext"><?php echo $personal_card->job . " • " . $personal_card->lookingForWorkString($personal_card->job) ?></p>
                <div id="splitter">
                </div>
                <div class="person-property-container">
                    <div class="icon-container">
                        <img src="imgs/person.svg">
                    </div>
                    <p class="card-back-text person-property-text"><?php echo $personal_card->calculateAge($personal_card->dob) . " years" ?></p>
                </div>
                <div class="person-property-container">
                    <div class="icon-container">
                        <img src="imgs/phone.svg">
                    </div>
                    <p class="card-back-text person-property-text"><?php echo $personal_card->phone_number ?></p>
                </div>
                <div class="person-property-container">
                    <div class="icon-container">
                        <img src="imgs/envelope.svg">
                    </div>
                    <p class="card-back-text person-property-text"><?php echo $personal_card->email ?></p>
                </div>
                <a href="<?php echo $personal_card->web_page ?>">
                    <div class="person-property-container">
                        <div class="icon-container">
                            <img src="imgs/web.svg">
                        </div>
                        <p class="card-back-text person-property-text">Github</p>
                    </div>
                </a>
                <div class="person-property-container">
                    <div class="icon-container">
                        <img src="imgs/building.svg">
                    </div>
                    <p class="card-back-text person-property-text"><?php echo $personal_card->address ?></p>
                </div>

        </div>


</body>

</html>