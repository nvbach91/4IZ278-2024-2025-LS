<?php
class Person {
    public function __construct(
        public $name,
        public $surname,
        public $email,
        public $phone,
        public $dob,
        public $company,
        public $street,
        public $oNumber,
        public $pNumber,
        public $city,
        public $website,
        public $work,
        public $position

    )
    {}
   public function getFullName() {
    return "$this->name $this->surname";
   }

   public function getAge() { 
    $date = date_create_from_format("j.n.Y", $this->dob);
    return date_diff($date, new DateTime('now'))->format("%Y") ;
   }
   public function getAddress() {
    return "$this->street $this->oNumber/$this->pNumber";
}


}
?>