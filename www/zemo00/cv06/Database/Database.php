<?php

require_once __DIR__ . "/database_config.php";
require_once __DIR__ . "/database_operations.php";

abstract class Database implements DatabaseOperations {

    protected $connection;
    protected $tableName;

    public function __construct()
    {
        $this->connection = new PDO(
            "mysql:host=" . DB_SERVER_URL . ";" . 
            "dbname=" . DB_DATABASE,
            DB_USERNAME,
            DB_PASSWORD
        );
        $this->connection->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC
        );
        $this->connection->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
    }

    public function insert($args): bool {
        $columns = implode(", ", array_keys($args));
        $values = implode(", ", array_values($args));

        $sql = "INSERT INTO $this->tableName($columns)
                    VALUES($values);";
        $statement = $this->connection->prepare($sql);

        return $statement->execute($args);
    }

    public function fetch($args) {
        $columns = implode(", ", $args['columns']);
        $conditions = implode(" AND ", $args['conditions']);
     
        $sql = "SELECT $columns FROM $this->tableName";
        if(!empty($conditions)){
            $sql = $sql . " WHERE $conditions;";
        }

        $statement = $this->connection->prepare($sql);
        
        foreach ($args['conditions'] as $condition) {
            preg_match_all('/:([a-zA-Z_]+)/', $condition, $matches); // Find named placeholders
            foreach ($matches[0] as $placeholder) {
                if (isset($args[$placeholder])) { // Check if the placeholder exists in args
                    $statement->bindValue($placeholder, $args[$placeholder]); // Bind the value
                }
            }
        }
        
        $statement->execute();

        return $statement->fetchAll();
    }

    public function fetchAll(){
        $sql = "SELECT * FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function update($args): bool {
        $update = $args['update'];
        $conditions = implode(" AND ", $args['conditions']);

        $sql = "UPDATE $this->tableName SET $update WHERE $conditions;";
        $statement = $this->connection->prepare($sql);

        return $statement->execute($args);
    }

    public function delete($args): bool {
        $conditions = implode(" AND ", $args['conditions']);

        $sql = "DELETE FROM $this->tableName WHERE $conditions;";
        $statement = $this->connection->prepare($sql);

        return $statement->execute($args);
    }

}


?>