<?php
class User
{
    var $name;
    var $email;
    var $password;

    function __construct($name, $email, $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    function formatToCsv()
    {
        return "$this->name;$this->email;$this->password";
    }
}
