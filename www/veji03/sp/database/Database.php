<?php
require_once __DIR__ . '/database-config.php';

class Database {
    private static ?PDO $connection = null;

    public function getConnection(): PDO {
        if (self::$connection === null) {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE . ';charset=utf8mb4';
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            self::$connection = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
        }

        return self::$connection;
    }
}
