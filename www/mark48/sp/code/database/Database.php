<?php

/**
 * Database connection class
 */
class Database
{
    private static $instance = null;
    private $connection;

    /**
     * Private constructor - Singleton pattern
     */
    private function __construct()
    {
        try {
            $this->connection = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Get database instance
     * @return Database
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Get PDO connection
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Execute a query with parameters
     * @param string $query SQL query
     * @param array $params Parameters for prepared statement
     * @return PDOStatement
     */
    public function query($query, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    /**
     * Get a single record
     * @param string $query SQL query
     * @param array $params Parameters for prepared statement
     * @return array|false Single record or false if no results
     */
    public function fetch($query, $params = [])
    {
        $stmt = $this->query($query, $params);
        return $stmt->fetch();
    }

    /**
     * Get multiple records
     * @param string $query SQL query
     * @param array $params Parameters for prepared statement
     * @return array Records
     */
    public function fetchAll($query, $params = [])
    {
        $stmt = $this->query($query, $params);
        return $stmt->fetchAll();
    }

    /**
     * Get the last inserted ID
     * @return string Last insert ID
     */
    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }

    /**
     * Begin a transaction
     */
    public function beginTransaction()
    {
        $this->connection->beginTransaction();
    }

    /**
     * Commit a transaction
     */
    public function commit()
    {
        $this->connection->commit();
    }

    /**
     * Rollback a transaction
     */
    public function rollback()
    {
        $this->connection->rollBack();
    }
}
