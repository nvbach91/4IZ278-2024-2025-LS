<?php

class Person {
    public function __construct(
        public $logo,
        public $firstName,
        public $lastName,
        public $position,
        public $company,
        public $isSearching,
        public $phone,
        public $email,
        public $webName,
        public $webUrl,
        public $street,
        public $streetNumber,
        public $postalCode,
        public $city,
        public $birthYear
    ) {}

    public function getAddress() {
        return "$this->streetNumber $this->street, $this->city, $this->postalCode";
    }
    public function getFullName() {
        return "$this->firstName $this->lastName";
    }

    public function getAvailability() {
        return $this->isSearching ? 'Looking for work' : 'Not looking for work';
    }

    public function getAge() {
        return date('Y') - $this->birthYear;
    }
}

?>