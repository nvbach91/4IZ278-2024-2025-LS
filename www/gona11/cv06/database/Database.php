<?php
require_once 'database-config.php';
require_once 'DatabaseConnection.php';
require_once 'DatabaseOperations.php'; ?>

<?php 
abstract class Database implements DatabaseOperations {
    protected $connection;
    protected $tableName;

    public function __construct() {
        $this->connection = DatabaseConnection::getPDOConnection();
    }

    public function find() {
        $sql = "SELECT * FROM $this->tableName";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findByCategory($value) {
        $sql = "SELECT * FROM $this->tableName WHERE category_id = $value";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function fetch($args) {
        $sql = "SELECT * FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
}

?>