<?php
require_once __DIR__ . "/Database.php";

class UserDB extends Database {
    protected $tableName = 'users';
    public function resetPassword($args){

    }
    public function changeAvatar($args){}
}