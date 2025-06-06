<?php
class Person {
    public function __construct(
    public $firstName,
    public $surname,
    public $phone,
    public $mail,
    public $webName,
    public $webSite,
    public $position,
    public $isSearching,
    public $birthYear,
    public $street,
    public $streetNumber,
    public $postalCode,
    public $city
    ){}
    
    public function getFullName() {
        return "{$this->firstName} {$this->surname}";
    }
    
}
?>