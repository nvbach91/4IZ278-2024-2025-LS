<?php

class Person
{
    public function __construct(
        public          $firstName,
        public          $surname,
        public DateTime $birthDate,
        public          $job,
        public          $company,
        public int      $phone,
        public          $street,
        public          $city,
        public          $email,
    )
    {
    }


    public function getFullName()
    {
        return "$this->firstName $this->surname";
    }

    public function getAddress()
    {
        return "$this->street , $this->city";
    }


}


?>