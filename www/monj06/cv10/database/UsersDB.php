<?php
require_once __DIR__ . '/Database.php';

class UsersDB extends Database
{
    protected $tableName = 'cv06_users';

    public function create($args)
    {
        $sql = "INSERT INTO cv06_users (email, password, privilege, name)
                    VALUES (:email, :password, :privilege, :name)";
        $passwordHash = password_hash($args['password'], PASSWORD_DEFAULT);
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            'email' => $args['email'],
            'password' => $passwordHash,
            'privilege' => $args['privilege'],
            'name' => $args['name'],
        ]);
    }
    public function findOneByEmail($email)
    {
        $sql = "SELECT * FROM cv06_users WHERE email = :email";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['email' => $email]);
        return $statement->fetch();
    }
    public function changeUserPrivilege($id, $privilege)
    {
        $sql = "UPDATE $this->tableName SET `privilege` = $privilege WHERE `user_id` = $id;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }
};
