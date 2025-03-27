<?php

namespace App\Tests\Unit;

use App\Entity\Account;
use App\Entity\Income;
use App\Entity\Expense;
use App\Entity\Transfer;
use App\Service\AccountService;
use App\Tests\Traits\CreateMockCollectionTraits;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class AccountServiceUnitTest extends TestCase
{
    use CreateMockCollectionTraits;

    public function testGetInputSum(): void
    {
        $account = $this->createMock(Account::class);
        $incomes = $this->createGetValueMockCollection([
            ['class' => Income::class, 'amount' => '100.20'],
            ['class' => Income::class, 'amount' => '200.50'],
        ]);
        $account->method('getIncomes')->willReturn($incomes);

        $service = new AccountService($account);
        $this->assertEqualsWithDelta(300.70, $service->getInputSum(), 0.01);
    }

    public function testGetOutputSum(): void
    {
        $account = $this->createMock(Account::class);
        $expenses = $this->createGetValueMockCollection([
            ['class' => Expense::class, 'amount' => '50'],
            ['class' => Expense::class, 'amount' => '30'],
        ]);
        $account->method('getExpenses')->willReturn($expenses);

        $service = new AccountService($account);
        $this->assertEqualsWithDelta(80, $service->getOutputSum(), 0.01);
    }

    public function testGetTotalTransfersIn(): void
    {
        $account = $this->createMock(Account::class);
        $transfersIn = $this->createGetValueMockCollection([
            ['class' => Transfer::class, 'amount' => '400'],
            ['class' => Transfer::class, 'amount' => '100'],
        ]);
        $account->method('getTransfersIn')->willReturn($transfersIn);

        $service = new AccountService($account);
        $this->assertEqualsWithDelta(500, $service->getTotalTransfersIn(), 0.01);
    }

    public function testGetTotalTransfersOut(): void
    {
        $account = $this->createMock(Account::class);
        $transfersOut = $this->createGetValueMockCollection([
            ['class' => Transfer::class, 'amount' => '150'],
            ['class' => Transfer::class, 'amount' => '50'],
        ]);
        $account->method('getTransfers')->willReturn($transfersOut);

        $service = new AccountService($account);
        $this->assertEqualsWithDelta(200, $service->getTotalTransfersOut(), 0.01);
    }

    public function testGetBalanceCalculation(): void
    {
        $account = $this->createMock(Account::class);

        $account->method('getIncomes')->willReturn($this->createGetValueMockCollection([
            ['class' => Income::class, 'amount' => '500'],
        ]));
        $account->method('getExpenses')->willReturn($this->createGetValueMockCollection([
            ['class' => Expense::class, 'amount' => '200'],
        ]));
        $account->method('getTransfersIn')->willReturn($this->createGetValueMockCollection([
            ['class' => Transfer::class, 'amount' => '300'],
        ]));
        $account->method('getTransfers')->willReturn($this->createGetValueMockCollection([
            ['class' => Transfer::class, 'amount' => '100'],
        ]));

        $service = new AccountService($account);
        // (500 - 200) + (300 - 100) = 500
        $this->assertEqualsWithDelta(500, $service->getBalance(), 0.01);
    }

    public function testEmptyCollectionsReturnZero(): void
    {
        $account = $this->createMock(Account::class);
        $emptyCollection = new ArrayCollection();

        $account->method('getIncomes')->willReturn($emptyCollection);
        $account->method('getExpenses')->willReturn($emptyCollection);
        $account->method('getTransfersIn')->willReturn($emptyCollection);
        $account->method('getTransfers')->willReturn($emptyCollection);

        $service = new AccountService($account);

        $this->assertEqualsWithDelta(0, $service->getInputSum(), 0.01);
        $this->assertEqualsWithDelta(0, $service->getOutputSum(), 0.01);
        $this->assertEqualsWithDelta(0, $service->getTotalTransfersIn(), 0.01);
        $this->assertEqualsWithDelta(0, $service->getTotalTransfersOut(), 0.01);
        $this->assertEqualsWithDelta(0, $service->getBalance(), 0.01);
    }
}
