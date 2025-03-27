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

    /** @var GoalService */
    private $service;

     /**
     * Sets up the test environment before each test.
     *
     * - Mocks a Goal entity with transfer data.
     * - Initializes the GoalService with the mocked Goal entity.
     */
    protected function setUp(): void
    {
        // Mock transfers with predefined amounts
        $transfers = $this->createGetValueMockCollection([
            ['class' => Transfer::class, 'amount' => '123.90'],
            ['class' => Transfer::class, 'amount' => '90'],
        ]);

        // Mock Goal entity
        $goal = $this->createMock(Goal::class);
        $goal->method('getTransfers')->willReturn($transfers);
        $goal->method('getValue')->willReturn('1000');

        // Initialize GoalService with the mocked Goal entity
        $this->service = new GoalService($goal);
    }

    /**
     * Tests the calculation of total transfers into the goal.
     *
     * This test ensures that the sum of all transfers linked to a goal is calculated correctly.
     */
    public function testGetTransfersIn(): void
    {
        // Expected sum: 123.90 + 90 = 213.90
        $this->assertEqualsWithDelta(213.90, $this->service->getTransfersIn(), 0.01);
    }

     /**
     * Tests the calculation of goal progress as a percentage.
     *
     * This test verifies that the progress is computed correctly based on the goal value.
     */
    public function testGetProgress(): void
    {
        // Expected progress: (213.90 / 1000) * 100 = 21.39%
        $this->assertEquals(21.39, $this->service->getProgress());
    }
}