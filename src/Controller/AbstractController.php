<?php 

namespace App\Controller;

use App\Config\DoctrineConfig;
use App\Config\RouterConfig;
use Doctrine\ORM\EntityManager;
use App\Service\TemplateRender;

abstract class AbstractController
{
    protected EntityManager $entityManager;
    private TemplateRender $templateRender;

    public function __construct()
    {
        $this->entityManager = DoctrineConfig::getEntityManager();
        $this->templateRender = new TemplateRender();
    }

    protected function mapEntitiesToServices(string $entity, string $method): array
    {
        $entityClass = '\\App\\Entity\\'. $entity;
        $serviceClass = '\\App\\Service\\'. $entity . 'Service';

        if(!class_exists($entityClass)) {
            throw new \RuntimeException("{$entity} Entity does not exists!");
        }

        $repository = $this->entityManager->getRepository($entityClass)->$method();
        return array_map(fn($var) => new $serviceClass($var), $repository);

    }

    protected function render(string $template, array $data = [], array $styles = [], array $scripts = []): string
    {
       return $this->templateRender->render($template,$data, $styles, $scripts);
    }

    protected function generateUrl(string $routeName, array $parameters): string
    {
        $router = RouterConfig::getRouter();
        return $router->generateUrl($routeName, $parameters);
    }
}