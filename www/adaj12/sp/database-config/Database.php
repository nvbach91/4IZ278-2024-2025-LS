<?php
require_once 'DatabaseCore.php';
require_once 'DatabaseFunctions.php';

abstract class Database implements DatabaseFunctions {
    protected $pdo;
    protected $tableName;

    public function __construct() {
        $config = require __DIR__ . '/DatabaseCore.php';
        $dsn = "mysql:host={$config['host']};dbname={$config['db_name']};charset=utf8mb4";
        $this->pdo = new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function getPdo() {
        return $this->pdo;
    }

    public function fetchAll() {
        return $this->pdo->query("SELECT * FROM {$this->tableName}")->fetchAll();
    }
}
