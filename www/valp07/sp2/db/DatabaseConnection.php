<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php

class DatabaseConnection {
    private static $pdo;
    private function __construct() {}
    public static function getPDOConnection() {
        if (!self::$pdo) {
            try {
                self::$pdo = new PDO('mysql:host='. DB_HOSTNAME .';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                self::$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {
                exit('Connection to DB failed: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }

    public static function printConfig() {
        return 'database config: host: ' . DB_HOSTNAME . ', dbname: ' . DB_DATABASE . ', username: ' . DB_USERNAME;
    }
}

?>