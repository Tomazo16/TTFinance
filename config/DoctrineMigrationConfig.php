<?php

use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use App\Config\DoctrineConfig;
use Symfony\Component\Dotenv\Dotenv;

//Dotenv initialize
$dotenv = new Dotenv();
$dotenv->load('.env');

require_once "vendor/autoload.php";

// Ładujemy config migracji (ścieżki, tabela migracji itp.)
$config = new PhpFile(__DIR__ . '/packages/migrations.php');

// POBIERASZ EntityManagera z Twojej klasy konfiguracji
$entityManager = DoctrineConfig::getEntityManager();

// KLUCZOWE: Tworzymy DependencyFactory z ExistingEntityManager
return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));