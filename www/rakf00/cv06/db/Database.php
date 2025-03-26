<?php

require_once __DIR__."/db-config.php";
require_once __DIR__."/DatabaseOperations.php";

abstract class Database implements DatabaseOperations
{

    protected $connection;

    protected $tableName;

    public function __construct()
    {
        try {
            $this->connection = new PDO(
                "mysql:host=".DB_HOSTNAME.";dbname=".DB_DATABASE,
                DB_USERNAME,
                DB_PASSWORD,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                ],
            );
        } catch (PDOException $e) {
            error_log("Chyba připojení k databázi: ".$e->getMessage());
            die("Chyba připojení k databázi.");
        }
    }

    public function fetch($args)
    {
        $sql = "SELECT * FROM $this->tableName";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

}
