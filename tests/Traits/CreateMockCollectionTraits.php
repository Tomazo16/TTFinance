<?php 

namespace App\Tests\Traits;

use Doctrine\Common\Collections\ArrayCollection;

trait CreateMockCollectionTraits
{

    protected function createGetValueMockCollection(array $values): ArrayCollection
    {
        $collection = [];
        foreach ($values as $value) {
            $mock = $this->createMock($value['class']);
            $mock->method('getValue')->willReturn((string) $value['amount']);
            $collection[] = $mock;
        }
        return new ArrayCollection($collection);
    }
    protected function createMockCollection(array $values): ArrayCollection
    {
        $collection = [];
        foreach($values as $value) {
            $mock = $this->createMock($value['class']);

            foreach($value['methods'] as $method) {
                $mock->method($method['method'])->willReturn($method['value']);
            }
            $collection[] = $mock;
        }
        return new ArrayCollection($collection);
    }
}