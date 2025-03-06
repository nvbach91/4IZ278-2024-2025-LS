<?php

require_once 'utils.php';

class Person {
    private $firstName;
    private $lastName;
    private $birthDate;
    private $job;
    private $company;
    private $street;
    private $houseNumber;
    private $orientationNumber;
    private $city;
    private $phone;
    private $email;
    private $website;
    private $lookingForJob;
    private $picture;

    public function __construct($firstName, $lastName, $birthDate, $job, $company, $street, $houseNumber, $orientationNumber, $city, $phone, $email, $website, $lookingForJob, $picture) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
        $this->job = $job;
        $this->company = $company;
        $this->street = $street;
        $this->houseNumber = $houseNumber;
        $this->orientationNumber = $orientationNumber;
        $this->city = $city;
        $this->phone = $phone;
        $this->email = $email;
        $this->website = $website;
        $this->lookingForJob = $lookingForJob;
        $this->picture = $picture;
    }

    public function getFullName() {
        return $this->firstName . " " . $this->lastName;
    }

    public function getAge() {
        return calculateAge($this->birthDate);
    }

    public function getAddress() {
        return $this->street . " " . $this->houseNumber . "/" . $this->orientationNumber . ", " . $this->city;
    }

    public function getJob() {
        return $this->job;
    }

    public function getCompany() {
        return $this->company;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getWebsite() {
        return $this->website;
    }

    public function isLookingForJob() {
        return $this->lookingForJob;
    }

    public function getLookingForJobText() {
        return $this->lookingForJob ? "Yes" : "No";
    }

    public function getPicture() {
        return $this->picture;
    }
}
?>
