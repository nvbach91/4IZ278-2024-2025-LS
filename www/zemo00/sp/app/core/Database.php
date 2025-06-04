<?php

/**
 * Handles database connection using PDO. Provides a single shared PDO
 * instance by using the Singleton design pattern.
 */
class Database{
    
    /**
     * @var PDO|null The shared PDO instance. 
     */
    private static ?PDO $pdo = null;

    /**
     * Connects to the database and / or returns a PDO instance.
     * 
     * @return PDO The shared PDO connection.
     * @throws PDOException If the connection fails.
     */
    public static function connect(): PDO {
        if (self::$pdo === null) {
            $config = require __DIR__ . "/../../config/database_config.php";
            self::$pdo = new PDO(
                "mysql:host=" . $config['host'] . ";" .
                "dbname=" . $config['database'],
                $config['username'],
                $config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        }
        return self::$pdo;
    }

}


?>