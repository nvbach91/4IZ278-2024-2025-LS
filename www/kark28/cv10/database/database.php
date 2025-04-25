<?php 
require_once __DIR__ . '/database-config.php';
require_once __DIR__ . '/DatabaseOperations.php';


abstract class Database implements DatabaseOperations {
    protected $connection;
    protected $tableName;

    public function __construct() {
        $this->connection = new PDO(
          'mysql:host='. DB_SERVER_URL .';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD
        );
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function fetch($args) {
        $sql = "SELECT * FROM $this->tableName";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
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

    public function delete($id) {
        $sql = "DELETE FROM $this->tableName WHERE product_id = $id";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }


}
?>