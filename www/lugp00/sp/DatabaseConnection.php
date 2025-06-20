<?php

namespace App;

use PDO;
use PDOException;

class DatabaseConnection {
    private static ?PDO $pdo = null;

    public static function getPDOConnection(): PDO {
        if (self::$pdo === null) {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=utf8mb4',
                DB_SERVER_URL,
                DB_DATABASE
            );
            try {
                self::$pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                throw new PDOException('Chyba DB spojení: ' . $e->getMessage(), (int)$e->getCode());
            }
        }
        return self::$pdo;
    }
}
