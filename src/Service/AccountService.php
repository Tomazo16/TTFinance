<?php 

namespace App\Service;

use App\Entity\Account;

class AccountService
{

    public function __construct(
        private Account $account
    )
    {}

    public function getOutputSum(): float
    {
        return array_sum(array_map(fn($input) => $input->getValue(), $this->account->getExpenses()->toArray()));
    }

    public function getInputSum(): float
    {
        return array_sum(array_map(fn($input) => $input->getValue(), $this->account->getIncomes()->toArray()));
    }

    public function getTotalTransfersIn(): float
    {
        return array_sum(array_map(fn($input) => $input->getValue(), $this->account->getTransfersIn()->toArray()));
    }

    public function getTotalTransfersOut(): float
    {
        return array_sum(array_map(fn($input) => $input->getValue(), $this->account->getTransfers()->toArray()));
    }

    public function getBalance(): float
    {
        //(prop("Suma przychodów")-prop("Suma wydatków"))+(prop("Total transfer in")-prop("Total transfer out"))
        return ($this->getInputSum() - $this->getOutputSum()) + ($this->getTotalTransfersIn() - $this->getTotalTransfersOut());
    }
}