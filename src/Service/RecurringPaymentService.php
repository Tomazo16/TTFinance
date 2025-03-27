<?php 

namespace App\Service;

use App\Entity\Expense;
use App\Entity\RecurringPayment;
use DateTime;
use InvalidArgumentException;
use RuntimeException;

class RecurringPaymentService
{
    private int $billing;

    public function __construct(
        private RecurringPayment $recurringPayment
    )
    {
        $this->billing = match($this->recurringPayment->getBilling()) {
            "Monthly" => 1,
            "2-Monthly" => 2,
            "3-Monthly" => 3,
            "6-Monthly" => 6,
            "Yearly" => 12,
            default => throw new InvalidArgumentException("Invalid format of Billing value")
        };
    }

    public function getMonthlyCoast(): float
    {
        return $this->recurringPayment->getValue() / $this->billing;
    }

    public function getLastExpense(): ?DateTime
    {
        return ($lastExpense = $this->recurringPayment->getExpenses()->last()) ? $lastExpense->getDate() : NULL;
    }

    public function shouldGenerateExpense(DateTime $dateTime): bool
    {
        $recurringPaymentDate = $this->getLastExpense();

        if ($recurringPaymentDate) {
            $diff = $dateTime->diff($recurringPaymentDate);
            $monthsDifference = $diff->y * 12 + $diff->m;

            return $diff->invert === 1 && $monthsDifference >= $this->billing;
        }

        return $this->recurringPayment->getStartDate() <= $dateTime;
    }
    
    public function generateRecurringExpense(): Expense
    {
            $expense = new Expense();
            $expense->setName($this->recurringPayment->getName());
            $expense->setValue($this->recurringPayment->getValue());
            $expense->setDate(new DateTime());
            $expense->setAccount($this->recurringPayment->getAccount() ?? NULL);
            $expense->setCategory($this->recurringPayment->getCategory() ?? NULL);
            $expense->setRecurringPayment($this->recurringPayment);
    
            return $expense;
    }
}