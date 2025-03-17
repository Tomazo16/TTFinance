<?php 

namespace App\Config;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerConfig
{
    private static ?Logger $logger;

    public static function getLogger(): Logger 
    {
        if(self::$logger === null) {

            self::$logger = new Logger('app_logger');
           $file =  ($_ENV['APP_ENV'] === 'dev') ? 'dev.log' : 'prog.log';
            self::$logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/' . $file));
        }

        return self::$logger;
    }
}
