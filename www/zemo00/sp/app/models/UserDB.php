<?php

require_once __DIR__ . "/../core/Model.php";

class User extends Model {
    
    protected $tableName = 'sp_users';
    protected $primaryKey = 'user_id';

}

?>