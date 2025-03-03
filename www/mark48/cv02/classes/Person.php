<?php
class Person
{
    public $first_name;
    public $last_name;
    public $dob;
    public $company_name;
    public $phone_number;
    public $email;
    public $slogan;
    public $job;
    public $web_page;
    public $address;

    public function __construct(
        $first_name,
        $last_name,
        $dob,
        $company_name,
        $phone_number,
        $email,
        $slogan,
        $job,
        $web_page,
        $address
    ) {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->dob = $dob;
        $this->company_name = $company_name;
        $this->phone_number = $phone_number;
        $this->email = $email;
        $this->slogan = $slogan;
        $this->job = $job;
        $this->web_page = $web_page;
        $this->address = $address;
    }

    public function getFullName()
    {
        return "$this->first_name $this->last_name";
    }
    function calculateAge()
    {
        $dob_obj = new DateTime($this->dob);
        $now = new DateTime();
        $difference = $now->diff($dob_obj);
        return $difference->y;
    }

    function lookingForWorkString()
    {
        if ($this->job == Null) {
            return "Looking for work";
        } else {
            return "Not looking for work";
        }
    }
}
