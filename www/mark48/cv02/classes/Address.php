<?php
class Address
{
    public $street;
    public $house_number;
    public $city;
    public $zip;
    public $country;

    public function __construct($street, $city, $zip, $country, $house_number)
    {
        $this->street = $street;
        $this->house_number = $house_number;
        $this->city = $city;
        $this->zip = $zip;
        $this->country = $country;
    }
    public function __toString()
    {
        return "$this->street $this->house_number, $this->city, $this->zip, $this->country";
    }
}
