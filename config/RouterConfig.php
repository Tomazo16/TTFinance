<?php 

namespace App\Config;

use Exception;
use Tomazo\Router\Factory\RouterFactory;
use Tomazo\Router\Router;

class RouterConfig
{
    public static function getRouter(): Router
    {
        $logger = LoggerConfig::getLogger('routerConfig');
        $routerConfig =  require __DIR__ . '/packages/router.php';

        try{
            return RouterFactory::createRouter($routerConfig);
        } catch (Exception $e) {
            $logger->error($e->getMessage());
            die();
        }
    }
}