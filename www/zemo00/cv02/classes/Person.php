<?php
class Person {
    public function __construct(
        public $image,
        public $style,
        public $name,
        public $dob,
        public $position,
        public $company,
        public $address,
        public $contact,
        public $isLookingForWork
    )
    {}

    public function getFullName(){
        return $this->name[0] . " " . $this->name[1];
    }

    public function getPositionAtCompany() {
        return $this->position . " at " . $this->company;
    }

    public function getFullAddress() {
        return $this->address["street"] . " " . $this->address["street_num"] . "/" . $this->address["orientation_num"] . ", " . $this->address["zip"] . " " . $this->address["city"] . ", " . $this->address["state"];
    }

    public function getWorkMessage() {
        if ($this->isLookingForWork) {
            return "I am looking for work.";
        } else {
            return "I am not looking for work.";
        }
    }

}
?>