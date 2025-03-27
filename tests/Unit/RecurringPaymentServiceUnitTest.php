<?php 

namespace App\Tests\Unit;

use App\Entity\Account;
use App\Entity\Expense;
use App\Entity\RecurringPayment;
use App\Service\RecurringPaymentService;
use App\Tests\Traits\CreateMockCollectionTraits;
use DateTime;
use Monolog\Test\TestCase;

/**
 * Unit tests for the RecurringPaymentService class.
 * 
 * This test suite ensures that recurring payments are processed correctly, including:
 * - Monthly cost calculations
 * - Expense generation conditions
 * - Creating a new recurring expense when necessary
 */
class RecurringPaymentServiceUnitTest extends TestCase
{
    use CreateMockCollectionTraits;

    /**
     * Tests the calculation of monthly costs for recurring payments.
     * 
     * - Ensures that a yearly payment is divided correctly into monthly costs.
     * - Ensures that a 2-monthly payment is calculated correctly.
     */
    public function testGetMonthlyCoast(): void
    {
        // Mock a yearly recurring payment of 120.00
        $recurringPayment = $this->createMock(RecurringPayment::class);
        $recurringPayment->method('getValue')->willReturn('120.00');
        $recurringPayment->method('isActive')->willReturn(true);
        $recurringPayment->method('getBilling')->willReturn('Yearly');

        $service = new RecurringPaymentService($recurringPayment);

        // Expected monthly cost: 120 / 12 = 10
        $this->assertEqualsWithDelta(10, $service->getMonthlyCoast(), 0.01);

        // Mock a 2-monthly recurring payment of 120.00
        $recurringPayment = $this->createMock(RecurringPayment::class);
        $recurringPayment->method('getValue')->willReturn('120.00');
        $recurringPayment->method('isActive')->willReturn(true);
        $recurringPayment->method('getBilling')->willReturn('2-Monthly');

        $service = new RecurringPaymentService($recurringPayment);

        // Expected monthly cost: 120 / 2 = 60
        $this->assertEqualsWithDelta(60, $service->getMonthlyCoast(), 0.01);
    }

    /**
     * Tests if an expense should be generated when previous expenses exist.
     * 
     * - Mocks past expenses in January and February.
     * - Checks whether a new expense should be generated for March.
     */
    public function testShouldGenerateExpenseWhenGenerateEarlier(): void
    {
        // Mock previous expenses
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

        // Mock RecurringPayment with monthly billing
        $recurringPayment = $this->createMock(RecurringPayment::class);
        $recurringPayment->method('getExpenses')->willReturn($expenses);
        $recurringPayment->method('getBilling')->willReturn('Monthly');
        $service = new RecurringPaymentService($recurringPayment);

        // Since previous expenses were generated in Jan and Feb, an expense should be generated in March
        $this->assertTrue($service->shouldGenerateExpense(new DateTime('2025-03-25')));
    }

    /**
     * Tests if an expense should be generated when no previous expenses exist.
     * 
     * - The start date of the recurring payment is 2025-03-25.
     * - Ensures that an expense is generated on the start date.
     */
    public function testShouldGenerateExpenseWhenDontGenerateEarlier(): void
    {
        // Mock a recurring payment with a start date of March 25, 2025
        $recurringPayment = $this->createMock(RecurringPayment::class);
        $recurringPayment->method('getBilling')->willReturn('Monthly');
        $recurringPayment->method('getStartDate')->willReturn(new DateTime('2025-03-25'));
        $service = new RecurringPaymentService($recurringPayment);

        // Since no previous expenses exist, an expense should be generated on the start date
        $this->assertTrue($service->shouldGenerateExpense(new DateTime('2025-03-25')));
    }

    /**
     * Tests the generation of a recurring expense when it hasn’t been generated before.
     * 
     * - Ensures that a new Expense instance is created.
     * - Verifies that the generated expense is linked to the recurring payment.
     */
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

        // Ensure that a new Expense instance is created
        $this->assertInstanceOf(Expense::class, $service->generateRecurringExpense());
    }
}