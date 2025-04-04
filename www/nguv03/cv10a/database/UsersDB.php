<?php
const DB_SERVER_URL = 'localhost';
const DB_USERNAME = 'root';
const DB_PASSWORD = '';
const DB_DATABASE = 'cv10';
class UsersDB {
    protected $connection;
    public function __construct() {
        $this->connection = new PDO(
            'mysql:host=' . DB_SERVER_URL . ';dbname=' . DB_DATABASE,
            DB_USERNAME,
            DB_PASSWORD,
        );
        $this->connection->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC
        );
    }
    public function create($args) {
        $sql = "
            INSERT INTO
            users (email, password, privilege, name)
            VALUES (:email, :password, :privilege, :name)
        ";
        $passwordHash = password_hash($args['password'], PASSWORD_DEFAULT);
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            'email' => $args['email'],
            'password' => $passwordHash,
            'privilege' => $args['privilege'],
            'name' => $args['name'],
        ]);
    }
    public function findOneByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        // $passwordHash = password_hash($args['password'], PASSWORD_DEFAULT);
        $statement = $this->connection->prepare($sql);
        $statement->execute([ 'email' => $email ]);
        return $statement->fetch();
    }
}
?>