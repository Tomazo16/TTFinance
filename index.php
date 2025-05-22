<?php 

require_once "vendor/autoload.php";

use App\Config\LoggerConfig;
use App\Config\RouterConfig;
use Symfony\Component\Dotenv\Dotenv;


//Dotenv initialize
$dotenv = new Dotenv();
$dotenv->load('.env');

//Logger initialize
$logger = LoggerConfig::getLogger('index');

//Router initialize
$router = RouterConfig::getRouter();

try{

    $path = $_SERVER['REQUEST_URI'];
    $scriptName = dirname($_SERVER['SCRIPT_NAME']);
    $route = '/' . trim(str_replace($scriptName, '', $path), '/');

    $router->getActionMethod($route);
} catch (Exception $e) {
    $logger->error($e->getMessage());
}
