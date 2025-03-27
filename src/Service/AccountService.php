<?php 

namespace App\Service;

use App\Entity\Account;

/**
 * Service for managing financial calculations related to an account.
 */
class AccountService
{

     /**
     * Constructor initializes the Account entity.
     *
     * @param Account $account The account entity.
     */
    public function __construct(
        private Account $account
    )
    {}

    /**
     * Calculates the total sum of expenses for the account.
     *
     * @return float The total amount spent.
     */
    public function getOutputSum(): float
    {
        return array_sum(array_map(fn($input) => $input->getValue(), $this->account->getExpenses()->toArray()));
    }

    /**
     * Calculates the total sum of incomes for the account.
     *
     * @return float The total income received.
     */
    public function getInputSum(): float
    {
        return array_sum(array_map(fn($input) => $input->getValue(), $this->account->getIncomes()->toArray()));
    }

    /**
     * Calculates the total sum of incoming transfers to the account.
     *
     * @return float The total amount transferred in.
     */
    public function getTotalTransfersIn(): float
    {
        return array_sum(array_map(fn($input) => $input->getValue(), $this->account->getTransfersIn()->toArray()));
    }

    /**
     * Calculates the total sum of outgoing transfers from the account.
     *
     * @return float The total amount transferred out.
     */
    public function getTotalTransfersOut(): float
    {
        return array_sum(array_map(fn($input) => $input->getValue(), $this->account->getTransfers()->toArray()));
    }

     /**
     * Calculates the account balance based on incomes, expenses, and transfers.
     *
     * Formula:
     * (Total Incomes - Total Expenses) + (Total Transfers In - Total Transfers Out)
     *
     * @return float The calculated balance.
     */
    public function getBalance(): float
    {
        return ($this->getInputSum() - $this->getOutputSum()) + ($this->getTotalTransfersIn() - $this->getTotalTransfersOut());
    }
}