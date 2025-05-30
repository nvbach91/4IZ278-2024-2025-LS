<?php

/**
 * User model
 */
class User
{
    public $id;
    public $name;
    public $email;
    public $role_id;
    public $role_name;
    public $created_at;
    public $facebook_id;

    /**
     * Constructor
     */
    public function __construct($data = null)
    {
        if ($data) {
            $this->id = $data['id'] ?? null;
            $this->name = $data['name'] ?? null;
            $this->email = $data['email'] ?? null;
            $this->role_id = $data['role_id'] ?? null;
            $this->role_name = $data['role_name'] ?? null;
            $this->created_at = $data['created_at'] ?? null;
            $this->facebook_id = $data['facebook_id'] ?? null;
        }
    }
}
