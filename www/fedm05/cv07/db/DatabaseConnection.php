<?php

class DatabaseConnection
{
    private static ?PDO $instance = null;
    private static string $host = 'localhost';
    private static string $dbName = 'fedm05';
    private static string $username = 'root';
    private static string $password = '';
    private static string $charset = 'utf8mb4';

    private function __construct() {}
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbName . ";charset=" . self::$charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            try {
                self::$instance = new PDO($dsn, self::$username, self::$password, $options);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                exit;
            }
        }

        return self::$instance;
    }
}
