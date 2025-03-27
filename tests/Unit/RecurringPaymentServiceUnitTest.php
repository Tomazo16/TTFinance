<?php 

namespace App\Tests\Unit;

use App\Entity\Account;
use App\Entity\Expense;
use App\Entity\RecurringPayment;
use App\Service\RecurringPaymentService;
use App\Tests\Traits\CreateMockCollectionTraits;
use DateTime;
use Monolog\Test\TestCase;

class RecurringPaymentServiceUnitTest extends TestCase
{
    use CreateMockCollectionTraits;

    public function testGetMonthlyCoast(): void
    {
        $recurringPayment = $this->createMock(RecurringPayment::class);
        $recurringPayment->method('getValue')->willReturn('120.00');
        $recurringPayment->method('isActive')->willReturn(true);
        $recurringPayment->method('getBilling')->willReturn('Yearly');

        $service = new RecurringPaymentService($recurringPayment);

        $this->assertEqualsWithDelta(10, $service->getMonthlyCoast(), 0.01);

        $recurringPayment = $this->createMock(RecurringPayment::class);
        $recurringPayment->method('getValue')->willReturn('120.00');
        $recurringPayment->method('isActive')->willReturn(true);
        $recurringPayment->method('getBilling')->willReturn('2-Monthly');

        $service = new RecurringPaymentService($recurringPayment);

        $this->assertEqualsWithDelta(60, $service->getMonthlyCoast(), 0.01);
    }

    public function testShouldGenerateExpenseWhenGenerateEarlier(): void
    {
        
        $expenses = $this->createMockCollection([
            ['class' => Expense::class, 'methods' => [
                ['method' => 'getId', 'value' => 1],
                ['method' => 'getDate', 'value' => new DateTime('2025-01-24')]
            ]],
            ['class' => Expense::class, 'methods' => [
                ['method' => 'getId', 'value' => 2],
                ['method' => 'getDate', 'value' => new DateTime('2025-02-25')]
            ]],
        ]);

        $recurringPayment = $this->createMock(RecurringPayment::class);
        $recurringPayment->method('getExpenses')->willReturn($expenses);
        $recurringPayment->method('getBilling')->willReturn('Monthly');
        $service = new RecurringPaymentService($recurringPayment);

        $this->assertTrue($service->shouldGenerateExpense(new DateTime('2025-03-25')));
    }

    public function testShouldGenerateExpenseWhenDontGenerateEarlier(): void
    {
        $recurringPayment = $this->createMock(RecurringPayment::class);
        $recurringPayment->method('getBilling')->willReturn('Monthly');
        $recurringPayment->method('getStartDate')->willReturn(new DateTime('2025-03-25'));
        $service = new RecurringPaymentService($recurringPayment);

        $this->assertTrue($service->shouldGenerateExpense(new DateTime('2025-03-25')));
    }

    public function testGenerateReccuringExpenseWhenItIsintGenerateEarlier() : void
    {
        $account = $this->createMock(Account::class);
        $recurringPayment = $this->createMock(RecurringPayment::class);
        $recurringPayment->method('getName')->willReturn('TestRecurringPayment');
        $recurringPayment->method('getValue')->willReturn('34,99');
        $recurringPayment->method('getAccount')->willReturn($account);
        $recurringPayment->method('getBilling')->willReturn('Monthly');
        $recurringPayment->method('getStartDate')->willReturn(new DateTime('2025-03-25'));
        $service = new RecurringPaymentService($recurringPayment);

        $this->assertInstanceOf(Expense::class, $service->generateRecurringExpense());
    }
}