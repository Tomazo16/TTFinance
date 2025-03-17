<?php 

namespace App\Config;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception as DBALException;
use Doctrine\ORM\Exception as ORMException;


class DoctrineConfig
{
    private static ?EntityManager $entityManager = null;

    public static function getEntityManager(): EntityManager
    {
        if (self::$entityManager === null) {

            $logger = LoggerConfig::getLogger();

            try {
                $databaseUrl = $_ENV['DATABASE_URL'] ?? null;
                if (!$databaseUrl) {
                    throw new \RuntimeException("Missing DATABASE_URL configuration in .env file");
                }

                // Konfiguracja Doctrine ORM
                $config = ORMSetup::createAttributeMetadataConfiguration(
                    paths: [__DIR__ . '/../src/Entity'],
                    isDevMode: true
                );

                // Konfiguracja połączenia do bazy
                $connectionParams = ['url' => $databaseUrl];
                $connection = DriverManager::getConnection($connectionParams, $config);

                // Tworzenie EntityManagera
                self::$entityManager = new EntityManager($connection, $config);
            } catch (DBALException $e) {
                $logger->error("Database error: " . $e->getMessage());
                die();
            } catch (ORMException $e) {
                $logger->error("Error Doctrine ORM: " . $e->getMessage());
                die();
            } catch (\RuntimeException $e) {
                $logger->error("Runtime error: " . $e->getMessage());
                die();
            } catch (\Throwable $e) {
                $logger->error("Unexpected error: " . $e->getMessage());
                die();
            }
        }

        return self::$entityManager;
    }
}