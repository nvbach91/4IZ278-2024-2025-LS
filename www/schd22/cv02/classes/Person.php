<?php
class Person {
public function __construct(
    public $lastName,
    public $name,
    public $age,
    public $job,
    public $firm,
    public $street,
    public $cityNumber,
    public $city,
    public $mobile,
    public $web
) {}

public function getAddress() {
    return "$this->street $this->city $this->cityNumber";
}

}
?>