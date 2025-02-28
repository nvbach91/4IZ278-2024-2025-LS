<?php
class Person
{   public function __construct(
    public $name,
    public $surname,
    public $occupation,
    public $dateOfBirth,
    public $phoneNumber,
    public $email,
    public $website,
    public $website_link,
    public $logo,
    public $street,
    public $city,
    public $slogan1,
    public $slogan2
    )
    {}

    function getAdress()
    {
        return $this->street . ", " . $this->city;
    }

    function getAge()
    {
        $dateOfBirth = new DateTime($this->dateOfBirth);
        $currentDate = new DateTime();
        $age = $currentDate->diff($dateOfBirth)->y;
        return $age;
    }
}
?>