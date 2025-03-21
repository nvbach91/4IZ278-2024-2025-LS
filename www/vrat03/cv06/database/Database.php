<?php require __DIR__.'/database-config.php';?>
<?php require __DIR__.'/DatabaseOperations.php';?>
<?php

abstract class Database implements DatabaseOperations {
    protected $connection;
    protected $tableName;
    public function  __construct() {
        $this->connection = new PDO(
            'mysql:host=' . DB_SERVER_URL . ';' . 'dbname=' . DB_DATABASE,
            DB_USERNAME,
            DB_PASSWORD
        );
        $this->connection->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE, 
            PDO::FETCH_ASSOC
        );
    }
    public function fetchAll($args) {
        $sql="SELECT * FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
}

?>