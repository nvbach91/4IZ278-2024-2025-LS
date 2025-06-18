<?php require_once 'db-config.php'; ?>
<?php

class DatabaseConnection {
    private static $pdo;
    public static function getPDOConnection() {
        if (!self::$pdo) {
            self::$pdo = new PDO(
                "mysql:host=" . DB_SERVER_URL . ";dbname=" . DB_DATABASE,
                DB_USERNAME,
                DB_PASSWORD
            );
            self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$pdo;
    }
}
?>