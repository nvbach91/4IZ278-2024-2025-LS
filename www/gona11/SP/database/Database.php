<?php
    require_once "db-connection.php";
    require_once "db-operations.php"; 
?>  

<?php 
abstract class Database implements DatabaseOperations {
    protected $connection;
    protected $tableName;

    public function __construct() {
        $this->connection = DatabaseConnection::getPDOConnection();
    }

    public function fetch($args) {
        $sql = "SELECT * FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
}

?>