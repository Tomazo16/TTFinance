<?php 

namespace App\Config;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerConfig
{
    private static ?Logger $logger = null;

    public static function getLogger(string $name): Logger 
    {
        if(self::$logger === null) {

            self::$logger = new Logger($name);
           $file =  ($_ENV['APP_ENV'] === 'dev') ? 'dev.log' : 'prog.log';
            self::$logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/' . $file));
        }

        return self::$logger;
    }
}
