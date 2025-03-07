<?php
class Person {
    public $avatar;
    public $firstname;
    public $surname;
    public $birthdate;
    public $field_of_work;
    public $company;
    public $street;
    public $zip;
    public $street_number;
    public $city;
    public $phone_number;
    public $email;
    public $web;
    public $open_to_work;

    public function __construct($avatar, $firstname, $surname, $birthdate, $field_of_work, $company, $street, $zip, $street_number, $city, $phone_number, $email, $web, $open_to_work) {
        $this->avatar = $avatar;
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->birthdate = $birthdate;
        $this->field_of_work = $field_of_work;
        $this->company = $company;
        $this->street = $street;
        $this->zip = $zip;
        $this->street_number = $street_number;
        $this->city = $city;
        $this->phone_number = $phone_number;
        $this->email = $email;
        $this->web = $web;
        $this->open_to_work = $open_to_work;
    }

    public function getFullName() {
        return $this->firstname . " " . $this->surname ;
    }

    public function getAddress() {
        return $this->street . " " . $this->street_number . " , " . $this->zip . " " . $this->city ;
    }

    public function getAge() {
        $today = new DateTime("now");
        $interval = $this->birthdate->diff($today);
        return $interval->y;
    }
}
?>