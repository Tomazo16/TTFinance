<?php 

namespace App\Tests\Unit;

use App\Entity\Category;
use App\Entity\Expense;
use App\Service\CategoryService;
use App\Tests\Traits\CreateMockCollectionTraits;
use DateTime;
use Monolog\Test\TestCase;

class CategoryServiceUnitTest extends TestCase
{
    use CreateMockCollectionTraits;

    public function testGetMonthlyExpenses(): void
    {
        $category = $this->createMock(Category::class);
        $expenses = $this->createMockCollection([
            ['class' => Expense::class, 'methods' => [
                ['method' => 'getValue', 'value' => '450'],
                ['method' => 'getDate', 'value' => new DateTime('2025-03-24')]
            ]],
            ['class' => Expense::class, 'methods' =>[
                ['method' => 'getValue', 'value' => '200'],
                ['method' => 'getDate', 'value' => new DateTime('2025-03-24 13:00:00')]
            ]],
            ['class' => Expense::class, 'methods' =>[
                ['method' => 'getValue', 'value' => '320'],
                ['method' => 'getDate', 'value' => new DateTime('2025-03-20')]
            ]],
            ['class' => Expense::class, 'methods' =>[
                ['method' => 'getValue', 'value' => '320'],
                ['method' => 'getDate', 'value' => new DateTime('2025-01-12')]
            ]],
        ]);
        $category->method('getExpenses')->willReturn($expenses);

        $service = new CategoryService($category);
        $this->assertEqualsWithDelta(970, $service->getMonthlyExpenses(new DateTime('2025-03-24')), 0.01);
    }

    public function testGetMonthlyProgress(): void
    {
        $category = $this->createMock(Category::class);
        $expenses = $this->createMockCollection([
            ['class' => Expense::class, 'methods' => [
                ['method' => 'getValue', 'value' => '450.12'],
                ['method' => 'getDate', 'value' => new DateTime('2025-03-24')]
            ]],
            ['class' => Expense::class, 'methods' =>[
                ['method' => 'getValue', 'value' => '20.56'],
                ['method' => 'getDate', 'value' => new DateTime('2025-03-24 13:00:00')]
            ]],
            ['class' => Expense::class, 'methods' =>[
                ['method' => 'getValue', 'value' => '320'],
                ['method' => 'getDate', 'value' => new DateTime('2025-03-20')]
            ]],
            ['class' => Expense::class, 'methods' =>[
                ['method' => 'getValue', 'value' => '320'],
                ['method' => 'getDate', 'value' => new DateTime('2025-01-12')]
            ]],
        ]);
        $category->method('getExpenses')->willReturn($expenses);
        $category->method('getBudget')->willReturn('1000.00');

        $service = new CategoryService($category);
        $this->assertEquals(79.07, $service->getMonthlyProgress(new DateTime('2025-03-24')));
    }
}