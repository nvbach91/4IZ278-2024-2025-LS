<?php

class Person {
    public function __construct(
        public $avatar,
        public $firstName,
        public $lastName,
        public $ocupation,
        public $company,
        public $street,
        public $propertyNumber,
        public $orientationNumber,
        public $city,
        public $phone,
        public $email,
        public $website,
        public $available,
        public $birthdate,
    ) {}

    public function getAddress() {
        return "$this->street $this->propertyNumber / $this->orientationNumber, $this->city";
    }

    public function getFullName() {
        return "$this->firstName $this->lastName";
    }

    public function getAge() {
        $birthDateTime = new DateTime($this->birthdate);
        $today = new DateTime('today');
        $age = $birthDateTime->diff($today)->y;
        return $age;
    }
}
?>