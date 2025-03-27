<?php 

namespace App\Service;

use App\Entity\Goal;

class GoalService
{
    public function __construct(
        private Goal $goal
    )
    {
        
    }

    public function getTransfersIn(): float
    {
        return array_sum(array_map(fn($input) => $input->getValue(), $this->goal->getTransfers()->toArray()));
    }

    public function getProgress(): float
    {
        $transfersValue = $this->getTransfersIn();
        return $transfersValue *100 / $this->goal->getValue();
    }
}