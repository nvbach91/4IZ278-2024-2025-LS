<?php
require './components/utils.php';

class Person {
    public $nameFirst;
    public $nameLast;
    public $profession;
    public $nameCompany;
    public $street;
    public $numberBuilding;
    public $numberOrientation;
    public $city;
    public $telephone;
    public $email;
    public $web;
    public $birthDate;
    public $avatar;
    public $logo;
    public $available;

    public function __construct($nameFirst, $nameLast, $profession, $nameCompany, 
                                $street, $numberBuilding, $numberOrientation, 
                                $city, $telephone, $email, $web, $birthDate, $avatar, $logo, $available = false) {
        $this->nameFirst = $nameFirst;
        $this->nameLast = $nameLast;
        $this->profession = $profession;
        $this->nameCompany = $nameCompany;
        $this->street = $street;
        $this->numberBuilding = $numberBuilding;
        $this->numberOrientation = $numberOrientation;
        $this->city = $city;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->web = $web;
        $this->birthDate = $birthDate;
        $this->avatar = $avatar;
        $this->logo = $logo;
        $this->available = $available;
    }

}
?>