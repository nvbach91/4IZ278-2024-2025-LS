<?php
class User
{
    var $name;
    var $email;
    var $phone;
    var $avatar;
    var $gender;

    function __construct($name, $email, $phone, $avatar, $gender)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->avatar = $avatar;
        $this->gender = $gender;
    }
}
