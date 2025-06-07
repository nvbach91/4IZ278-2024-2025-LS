<?php

require_once __DIR__ . "/Database.php";
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
    protected string $tableName;

    /**
     * The name of the primary key column / columns. Primary keys can be either
     * a number or string. Some tables are identified by composite keys.
     */
    protected string|array $primaryKey;

    /**
     * Columns allowed for sorting via the ORDER BY clause. If undefined, then this
     * table is not for sorting.
     */
    public ?array $sortingColumns;

    /**
     * The PDO database connection used by the model.
     * 
     * @var PDO
     */
    protected PDO $db;

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
     * @param string|int|array $id The primary key value(s).
     * @return array|null The found row. Null if not found.
     */
    public function fetchById(string|int|array $id): ?array{
        if ($this->validateIdFormat($id)) {
            if (is_array($this->primaryKey)) {
                $ids = [];
                foreach ($this->primaryKey as $idColumn){
                    $ids[] = "$idColumn = ?";
                }
                $whereClause = "WHERE " . implode(" AND ", $ids);
                $identifier = $id;
            } else {
                $whereClause = "WHERE $this->primaryKey = ?";
                $identifier = [$id];
            }
        } else {
            throw new InvalidArgumentException("Provided ID format does not match the primary key structure.");
        }
        $sql = "SELECT * FROM $this->tableName $whereClause";

        $statement = $this->db->prepare($sql);
        $statement->execute($identifier);
        return $statement->fetch() ?: null;
    }

    /**
     * Fetches all rows based on a condition in the WHERE clause.
     * 
     * @param array $conditions An array of conditions.
     * @param array|null $columns The columns to be fetched. Fetch
     *                   all columns on null.
     * @return array Matching rows.
     */
    public function fetchWhere(array $conditions, array|null $columns = null): array {
        if (empty($conditions ?? '')){
            $where = '';
        } else {

            $clauses = [];
            $values = [];
            foreach($conditions as $column => $value){
                $clauses[] = "$column = ?";
                $values[] = $value;
            }

            $where = " WHERE " . implode(" AND ", $clauses);

        }

        if (empty($columns ?? [])) {
            $cols = "*";
        } else {
            $cols = implode(", ", $columns);
        }

        $sql = "SELECT $cols FROM $this->tableName $where;";

        $statement = $this->db->prepare($sql);
        $statement->execute($values);

        return $statement->fetchAll();
    }

    /**
     * Fetches sorted rows.
     * 
     * @param string $column The column used in the ORDER BY clause.
     * @param string $direction Either ASC or DESC.
     * @throws InvalidArgumentException If $direction is not ASC nor DESC.
     * @throws InvalidArgumentException If the column used for sorting is not allowed.
     * @throws LogicException If this table is not allowed for sorting.
     */
    public function fetchSorted(string $column, string $direction): array {
        if (!is_array($this->sortingColumns)) {
            throw new LogicException("This table cannot be sorted.");
        }
        $direction = strtoupper($direction);
        if (!in_array($direction, ["ASC", "DESC"])) {
            throw new InvalidArgumentException("Invalid sort direction: must be 'ASC' or 'DESC'");
        }
        if (!in_array($column, $this->sortingColumns)) {
            throw new InvalidArgumentException("Invalid column name");
        }

        $sql = "SELECT * FROM $this->tableName ORDER BY `$column` $direction";

        $statement = $this->db->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Fetches all rows.
     * 
     * @return array All rows from the table.
     */
    public function fetchAll(): array
    {
        $sql = "SELECT * FROM $this->tableName";

        $statement = $this->db->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Updates a row matching the provided ID and optional WHERE conditions.
     * 
     * @param string|int|array $id The primary key value.
     * @param array $data Column names and values.
     * @param array $extraWhere Optional additional WHERE conditions.
     * @return bool True on success.
     */
    public function update(string|int|array $id, array $data, array $extraWhere = []): bool {
        if (empty($data)) {
            return false;
        }

        if (!$this->validateIdFormat($id)) {
            throw new InvalidArgumentException("Provided ID format does not match the primary key structure.");
        }

        $whereParts = [];
        $identifier = [];

        if (is_array($this->primaryKey)) {
            foreach ($this->primaryKey as $index => $col) {
                $whereParts[] = "$col = ?";
                $identifier[] = $id[$index];
            }
        } else {
            $whereParts[] = "$this->primaryKey = ?";
            $identifier[] = $id;
        }

        foreach ($extraWhere as $col => $val) {
            $whereParts[] = "$col = ?";
            $identifier[] = $val;
        }

        $whereClause = 'WHERE ' . implode(' AND ', $whereParts);

        $columns = [];
        $values = [];
        foreach ($data as $column => $value) {
            $columns[] = "$column = ?";
            $values[] = $value;
        }

        $sql = "UPDATE $this->tableName SET " . implode(', ', $columns) . " $whereClause";
        $statement = $this->db->prepare($sql);

        return $statement->execute(array_merge($values, $identifier));
    }
    
    /**
     * Deletes a row matching the provided id.
     * 
     * @param string|int|array $id The id of the row to be removed.
     * @return bool True on success.
     */
    public function delete(string|int|array $id): bool
    {
        if ($id == null || empty($id)){
            return false;
        }

        if ($this->validateIdFormat($id)) {
            if (is_array($this->primaryKey)) {
                $ids = [];
                foreach ($this->primaryKey as $idColumn){
                    $ids[] = "$idColumn = ?";
                }
                $whereClause = "WHERE " . implode(" AND ", $ids);
                $identifier = $id;
            } else {
                $whereClause = "WHERE $this->primaryKey = ?";
                $identifier = [$id];
            }
        } else {
            throw new InvalidArgumentException("Provided ID format does not match the primary key structure.");
        }

        $sql = "DELETE FROM $this->tableName $whereClause";

        $statement = $this->db->prepare($sql);

        return $statement->execute($identifier);
    }

    /**
     * Deletes rows not based on ID, but on a different condition.
     * 
     * @param array $conditions Conditions for the WHERE clause.
     * @return bool True on successful delete.
     */
    public function deleteWhere(array $conditions): bool {
        $where = '';
        if (empty($conditions ?? '')){
            return false;
        } else {

            $clauses = [];
            $values = [];
            foreach($conditions as $column => $value){
                $clauses[] = "$column = ?";
                $values[] = $value;
            }

            $where = " WHERE " . implode(" AND ", $clauses);

        }

        $sql = "DELETE FROM $this->tableName $where;";

        $statement = $this->db->prepare($sql);
        return $statement->execute($values);
    }

    /**
     * Checks whether rows with unique values already exist.
     * 
     * @param array $data An associative array of columns and values.
     * @return bool True if at least one exists
     */
    public function existsUnique(array $data): bool {
        foreach ($data as $column => $value) {
            $row = $this->fetchWhere([$column => $value]);
            if (!empty($row)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns the last auto-incremented ID of the last inserted row.
     * 
     * @return string The latest ID.
     */
    public function lastInsertId(): string {
        return $this->db->lastInsertId();
    }

    /**
     * Validates whether the provided ID matches the expected
     * structure of the table's primary key (single or composite).
     * 
     * @param string|int|array $id The provided id(s).
     * @return bool True if the ID format matches the expected one.
     */
    private function validateIdFormat($id): bool {
        if(is_array($this->primaryKey)){
            if(is_array($id)){
                foreach ($this->primaryKey as $key) {
                    if (!array_key_exists($key, $id)){
                        return false;
                    }
                }
                return true;
            }
            return false;
        }
        return !is_array($id);
    }

}


?>