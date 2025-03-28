<?php
require_once 'database-config.php';
require_once 'DatabaseConnection.php';
require_once 'DatabaseOperations.php';

abstract class Database implements DatabaseOpetations {
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

    public function findBy($field, $value) {
        $sql = "SELECT * FROM $this->tableName WHERE $field = :value";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['value' => $value]);
        return $statement->fetchAll();
    }

    public function fetch($args) {
        $sql = "SELECT * FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
}
