<?php
require_once __DIR__ . '/database.php';

class UserDB extends Database {
    protected $tableName = 'users';

    public function resetPassword($args) {}
    public function changeAvatar($args) {}
}