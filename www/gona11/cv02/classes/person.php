<?php 

class Person {
    public function __construct(
        public $first_name,
        public $last_name,
        public $avatar,
        public DateTime $birth_date,
        public $position, 
        public $adress,
        public $city,
        public $code,
        public $phone,
        public $email,
        public $seeking_job,
        public $instagram,
        public $github
    ) {}

    function getFullName () {
        return "$this->first_name  $this->last_name";
    }
    
    function getAge () {
        $today = new DateTime();
        $age = $today->diff($this->birth_date)->y;
        return $age;
    }
    
    function getInfo () {
        $age = $this->getAge();
        return "$age || $this->position";
    }

    function getCityCode () {
        return "$this->city $this->code";
    }

    function seekingJob () {
        $result = "Not available for contracts";
        if($this->seeking_job) {
            $result = "Available for contracts";
        }
        return $result;
    }
}
?>