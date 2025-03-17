<?php 

require_once "vendor/autoload.php";

use App\Config\DoctrineConfig;
use App\Config\LoggerConfig;
use Symfony\Component\Dotenv\Dotenv;

//Dotenv initialize
$dotenv = new Dotenv();
$dotenv->load('.env');


