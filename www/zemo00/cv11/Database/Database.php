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

    public function getCount(){
        $sql = "SELECT COUNT(*) AS count FROM $this->tableName;";

        $statement = $this->connection->prepare($sql);
        $statement->execute();

        return $statement->fetch()['count'];
    }

    public function insert($args): bool {
        $columns = implode(", ", array_keys($args));
        $placeholders = ":" . implode(", :", array_keys($args));
    
        $sql = "INSERT INTO $this->tableName ($columns) VALUES ($placeholders)";
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
            preg_match_all('/:([a-zA-Z_]+)/', $condition, $matches);
            foreach ($matches[0] as $placeholder) {
                if (isset($args[$placeholder])) {
                    $statement->bindValue($placeholder, $args[$placeholder]);
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

    public function fetchAllWithOffset($args){
        $limit = $args['limit'];
        $offset = $args['offset'];
        $sql = "SELECT * FROM $this->tableName LIMIT $limit OFFSET $offset;";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function update($args): bool {
        $update = $args['update'];
        $conditions = implode(" AND ", $args['conditions']);
    
        $sql = "UPDATE $this->tableName SET $update WHERE $conditions;";
        $statement = $this->connection->prepare($sql);
    
        $bindings = $args;
        unset($bindings['update'], $bindings['conditions']);
    
        return $statement->execute($bindings);
    }

    public function delete($args): bool {
        $conditions = implode(" AND ", $args['conditions']);
    
        $sql = "DELETE FROM $this->tableName WHERE $conditions;";
        $statement = $this->connection->prepare($sql);
    
        $bindings = $args;
        unset($bindings['conditions']);
    
        return $statement->execute($bindings);
    }

}


?>