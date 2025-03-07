<?php
class Person
{
    public function __construct(
        public $name,
        public $surname,
        public $position,
        public $company,
        public $planet,
        public $location,
        public $phoneNumber,
        public $email,
        public $web,
        public $avatar,
        public $lookingForJob,
        public $birthDate,
        public $background,
    ) {}

    function getAge()
    {
        $currentDate = new DateTime(date("Y/m/d"));
        $dateOfBirth = new DateTime($this->birthDate);
        $diff = $currentDate->diff($dateOfBirth);
        return $diff->y;
    }
    function getAvaiability()
    {
        if ($this->lookingForJob) {
            return "Looking for a job";
        } else {
            return "Not looking for a job";
        }
    }
}
