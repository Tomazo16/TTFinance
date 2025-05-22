<?php 

namespace App\Service;

use App\Entity\Expense;
use App\Entity\RecurringPayment;
use DateTime;
use InvalidArgumentException;

/**
 * Service for managing recurring payments.
 */
class RecurringPaymentService implements ServiceInterface
{
     /**
     * The number of months corresponding to the recurring payment frequency.
     */
    private int $billing;

    /**
     * Constructor initializes the RecurringPayment entity.
     * Sets the $billing value based on the entity's billing frequency.
     *
     * @param RecurringPayment $recurringPayment The recurring payment entity.
     *
     * @throws InvalidFormat If the "Billing" value is invalid.
     */
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

    public function getEntity(): RecurringPayment
    {
        return $this->recurringPayment;
    }

     /**
     * Calculates the monthly cost based on the payment value and frequency.
     *
     * @return float The monthly cost of the recurring payment.
     */
    public function getMonthlyCoast(): float
    {
        return $this->recurringPayment->getValue() / $this->billing;
    }

     /**
     * Retrieves the date of the last recorded expense for this recurring payment.
     *
     * @return DateTime|null The date of the last expense, or null if no expenses exist.
     */
    public function getLastExpense(): ?DateTime
    {
        return ($lastExpense = $this->recurringPayment->getExpenses()->last()) ? $lastExpense->getDate() : NULL;
    }

     /**
     * Determines whether a new expense should be generated based on the given date.
     *
     * @param DateTime $dateTime The date for which we check the necessity of a new expense.
     *
     * @return bool True if a new expense should be generated, false otherwise.
     */
    public function shouldGenerateExpense(DateTime $dateTime): bool
    {
        $recurringPaymentDate = $this->getLastExpense();

        if ($recurringPaymentDate) {
            // Calculate the time difference between the last expense and the given date
            $diff = $dateTime->diff($recurringPaymentDate);
            // Calculate the difference in months (including years)
            $monthsDifference = $diff->y * 12 + $diff->m;

            // If the difference is greater than or equal to the billing period, generate a new expense
            return $diff->invert === 1 && $monthsDifference >= $this->billing;
        }

        // If there are no previous expenses, check if the start date allows expense generation
        return $this->recurringPayment->getStartDate() <= $dateTime;
    }
    
    /**
     * Creates a new expense based on the recurring payment details.
     *
     * @return Expense The generated expense entity.
     */
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