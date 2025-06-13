<?php 

namespace App\Form;

use App\Config\DoctrineConfig;
use Doctrine\ORM\EntityManager;
use Tomazo\Form\FormInterface;

abstract class AbstractForm implements FormInterface
{
    protected EntityManager $entityManager;

    public function __construct()
    {
        $this-> entityManager = DoctrineConfig::getEntityManager();
    }

    protected function getData(string $entity): array
    {
        $objects = $this->entityManager->getRepository($entity)->findAll();

        if (!method_exists($entity, '__toString')) {
            throw new \LogicException("Class {$entity} does have __toString method");
        }

        return array_column(
            array_map(
                fn(object $obj) => ['id' => $obj->getId(), 'label' => (string) $obj],
                $objects
            ),
            'label',
            'id'
        );
    }

}