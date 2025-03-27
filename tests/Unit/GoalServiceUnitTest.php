<?php 

namespace App\Tests\Unit;

use App\Entity\Goal;
use App\Entity\Transfer;
use App\Service\GoalService;
use App\Tests\Traits\CreateMockCollectionTraits;
use Monolog\Test\TestCase;

class GoalServiceUnitTest extends TestCase
{
    use CreateMockCollectionTraits;

    private $service;

    protected function setUp(): void
    {
        $transfers = $this->createGetValueMockCollection([
            ['class' => Transfer::class, 'amount' => '123.90'],
            ['class' => Transfer::class, 'amount' => '90'],
        ]);
        $goal = $this->createMock(Goal::class);
        $goal->method('getTransfers')->willReturn($transfers);
        $goal->method('getValue')->willReturn('1000');

        $this->service = new GoalService($goal);
    }

    public function testGetTransfersIn(): void
    {
        $this->assertEqualsWithDelta(213.90, $this->service->getTransfersIn(), 0.01);
    }

    public function testGetProgress(): void
    {
        $this->assertEquals(21.39, $this->service->getProgress());
    }
}