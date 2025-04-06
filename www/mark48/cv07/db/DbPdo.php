<?php
// Database.php

class Database
{
    private static $instance = null;
    private $connection;

    // Make the constructor private to prevent multiple instances.
    private function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=mark48;charset=utf8';
        $username = 'mark48';
        $password = '';

        try {
            $this->connection = new PDO($dsn, $username, $password);
            // Set error mode to exception to catch errors easily.
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database Connection Error: " . $e->getMessage());
        }
    }

    // Return the single instance of Database.
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Get the PDO connection.
    public function getConnection()
    {
        return $this->connection;
    }
}
