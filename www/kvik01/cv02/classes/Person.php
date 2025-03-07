<?php

class Person{
    public function __construct(
        public $firstName,
        public $lastName,
        public $position,
        public $phone,
        public $street,
        public $streetNumber,
        public $city,
        public $country,
        public $zip,
    ){}

    public function getFullName(){
        // dvojite uvozovky - promenne se stanou soucasti vysledneho stringu
        return "$this->firstName $this->lastName";
    }

    public function getAddress(){
        // dvojite uvozovky - promenne se stanou soucasti vysledneho stringu
        return "$this->street $this->streetNumber, $this->city, $this->country, $this->zip";
    }

}

?>