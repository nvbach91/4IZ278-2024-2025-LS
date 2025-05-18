<?php

require_once __DIR__ . "/DatabaseOperations.php";

/**
 * Abstract base class for all models representing database tables.
 * Provides a default structure for implementing CRUD operations.
 */
abstract class Model implements DatabaseOperations{

    /**
     * The name of the database table.
     * 
     * Will be set by child classes.
     * 
     * @var string
     */
    protected $tableName;

    /**
     * The name of the primary key column.
     */
    protected $primaryKey;

    /**
     * The PDO database connection used by the model.
     * 
     * @var PDO
     */
    protected $db;

    /**
     * Connection to the database is established on initiation.
     */
    public function __construct() {
        $this->db = Database::connect();
    }

    /**
     * Function for inserting records into the database table.
     * 
     * @param array $data An associative array filled with data to be inserted.
     * @return bool True on success.
     */
    public function insert($data): bool{
        if(empty($data)){
            return false;
        }
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $sql = "INSERT INTO $this->tableName($columns)
                    VALUES($placeholders);";
        $statement = $this->db->prepare($sql);

        return $statement->execute(array_values($data));
    }

    /**
     * Fetches a single row that matches the id.
     * 
     * @param string|int $id The primary key value.
     * @return array|null The found row. Null if not found.
     */
    public function fetchById($id): ?array{
        $sql = "SELECT * FROM $this->tableName
                    WHERE $this->primaryKey = ?";

        $statement = $this->db->prepare($sql);
        $statement->execute([$id]);
        return $statement->fetch() ?: null;
    }

    /**
     * Fetches all rows based on a condition in the WHERE clause.
     * 
     * @param array $conditions An array of conditions
     * @return array Matching rows.
     */
    public function fetchWhere(array $conditions): array {
        if (empty($conditions)){
            return $this->fetchAll();
        }

        $clauses = [];
        $values = [];
        foreach($conditions as $column => $value){
            $clauses[] = "$column = ?";
            $values[] = $value;
        }

        $where = implode(" AND ", $clauses);

        $sql = "SELECT * FROM {$this->tableName} WHERE {$where};";

        $statement = $this->db->prepare($sql);
        $statement->execute($values);

        return $statement->fetchAll();
    }

}


?>