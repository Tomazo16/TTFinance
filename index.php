<?php 

require_once "vendor/autoload.php";

use App\Config\DoctrineConfig;
use App\Config\LoggerConfig;
use App\Config\RouterConfig;
use Symfony\Component\Dotenv\Dotenv;


//Dotenv initialize
$dotenv = new Dotenv();
$dotenv->load('.env');

//Logger initialize
$logger = LoggerConfig::getLogger('index');

try{
    $router = RouterConfig::getRouter();
   print_r($router->getRoutePaths());
} catch (Exception $e) {
    $logger->error($e->getMessage());
}
