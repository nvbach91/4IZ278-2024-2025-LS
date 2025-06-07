<?php

require_once __DIR__ . '/../config/config.php';

class Database
{
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $pdo;
    private $error;

    public function __construct()
    {
        $this->host = DB_HOST;
        $this->db_name = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASS;
    }

    public function connect()
    {
        if ($this->pdo === null) {
            try {
                $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
                ];

                $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                error_log("Database Connection Error: " . $e->getMessage());
                return null;
            }
        }
        return $this->pdo;
    }
    public function getPdo()
    {
        return $this->connect();
    }

    public function select($query, $params = [])
    {
        try {
            $pdo = $this->connect();
            if (!$pdo) return false;

            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Select Query Error: " . $e->getMessage());
            return false;
        }
    }

    public function insert($table, $data)
    {
        try {
            $pdo = $this->connect();
            if (!$pdo) return false;

            $columns = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            
            $query = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
            $stmt = $pdo->prepare($query);
            
            $result = $stmt->execute($data);
            return $result ? $pdo->lastInsertId() : false;
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Insert Query Error: " . $e->getMessage());
            return false;
        }
    }

    public function update($table, $data, $where)
    {
        try {
            $pdo = $this->connect();
            if (!$pdo) return false;

            $setClause = [];
            foreach ($data as $column => $value) {
                $setClause[] = "{$column} = :{$column}";
            }
            $setClause = implode(', ', $setClause);

            $whereClause = [];
            foreach ($where as $column => $value) {
                $whereClause[] = "{$column} = :where_{$column}";
            }
            $whereClause = implode(' AND ', $whereClause);

            $query = "UPDATE {$table} SET {$setClause} WHERE {$whereClause}";
            $stmt = $pdo->prepare($query);

            // Merge data and where parameters
            $params = $data;
            foreach ($where as $column => $value) {
                $params["where_{$column}"] = $value;
            }

            return $stmt->execute($params);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Update Query Error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($table, $where)
    {
        try {
            $pdo = $this->connect();
            if (!$pdo) return false;

            $whereClause = [];
            foreach ($where as $column => $value) {
                $whereClause[] = "{$column} = :{$column}";
            }
            $whereClause = implode(' AND ', $whereClause);
            $query = "DELETE FROM {$table} WHERE {$whereClause}";
            echo $query; // Debugging line, can be removed later
            $stmt = $pdo->prepare($query);

            return $stmt->execute($where);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Delete Query Error: " . $e->getMessage());
            return false;
        }
    }
    public function __destruct()
    {
        $this->pdo = null;
    }
}
?>