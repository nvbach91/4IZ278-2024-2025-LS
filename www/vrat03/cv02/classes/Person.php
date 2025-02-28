<?php

class Person {
    public function __construct(public $firstName,
                                public $lastName,
                                public $photo,
                                public $logo,
                                public $birth,
                                public $job,
                                public $company,
                                public $streetNumber,
                                public $street,
                                public $city,
                                public $state,
                                public $zip,
                                public $country,
                                public $email,
                                public $web,
                                public $searchingEmployees,
    ){}

    public function getAge() {
        return date('Y')-$this->birth;
    }

    public function getFullName() {
        return "$this->firstName $this->lastName";
    }

    public function isSearchingEmployees() {
        return $this->searchingEmployees ? 'Looking for new employees.' : 'Not hiring at the moment.';
    }

    public function getFullJob() {
        return "$this->job at $this->company";
    }

    public function getAddressLine($number) {
        switch($number) {
            case 1:
                return $this->company;
            case 2:
                return "$this->street $this->streetNumber";
            case 3:
                return "$this->city, $this->state $this->zip";
            case 4:
                return $this->country;
            default:
                return null;
        }
    }
}

?>