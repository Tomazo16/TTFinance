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
    $path = $_SERVER['REQUEST_URI'];
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$route = '/' . trim(str_replace($scriptName, '', $path), '/');
print_r($route);
    $router = RouterConfig::getRouter();
   print_r($router->getRoutes());
} catch (Exception $e) {
    $logger->error($e->getMessage());
}
