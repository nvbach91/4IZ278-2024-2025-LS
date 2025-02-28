<?php
class Person
{
    public function __construct(
        public $name,
        public $title,
        public $company,
        public $birthdate,
        public $street,
        public $building_number,
        public $location_number,
        public $post_number,
        public $city,
        public $phone,
        public $email,
        public $website,
        public $looking_for_work,
        public $expertise
    ) {}

    public function getCompleteAddress()
    {
        return "$this->street $this->location_number/$this->building_number, $this->city";
    }

    public function lookingForWork()
    {
        return $this->looking_for_work ? "Currently looking for work" : "Not looking for work at the moment";
    }

    public function calculateAge()
    {
        $today = new DateTime();
        $age = $today->diff($this->birthdate)->y;
        return " $age years old";
    }
}
