<?php
class User
{
    private $user_id;
    private $email;
    private $password;
    private $privilege;
    private $name;

    public function __construct($user_id, $email, $password, $privilege, $name)
    {
        $this->user_id   = $user_id;
        $this->email     = $email;
        $this->password  = $password;
        $this->privilege = $privilege;
        $this->name      = $name;
    }

    // Gettery
    public function getUserId()
    {
        return $this->user_id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getPrivilege()
    {
        return $this->privilege;
    }
    public function getName()
    {
        return $this->name;
    }
}
