<?php require_once __DIR__ . '/../vendor/autoload.php'; ?>
<?php

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class AppLogger {
    private static ?Logger $logger = null;

    public static function getLogger(): Logger {
        if (self::$logger === null) {
            self::$logger = new Logger('TomsShopLogger');

            $week = date('o-\WW');
            $logPath = __DIR__ . "/../logs/app-".$week.".log";
            $handler = new StreamHandler($logPath, Level::Debug);

            self::$logger->pushHandler($handler);
        }
        return self::$logger;
    }
}


?>