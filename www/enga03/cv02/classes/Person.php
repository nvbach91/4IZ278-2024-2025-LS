<?php

class Person {
    public function __construct(
        public $name,
        public $dateOfBirth,
        public $jobs,
        public $companyName,
        public $streetName,
        public $buildingNumber,
        public $orientationNumber,
        public $city,
        public $phoneNumber,
        public $email,
        public $webpage,
        public $lookingForJob,
        public $logoPath
    ) {}

    public function getAge(): int {
        $now = new DateTime();
        return ($now->diff($this->dateOfBirth))->y;
    }

    public function getFullName(): string {
        return $this->name[0] . " " . $this->name[1];
    }

    public function getAddress(): string {
        return $this->streetName . " " . $this->buildingNumber . "/" . $this->orientationNumber . ", " . $this->city;
    }

    public function isLookingForJob(): string {
        return $this->lookingForJob ? "I am looking for a job." : "I am not looking for a job.";
    }
}
?>