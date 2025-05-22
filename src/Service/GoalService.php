<?php 

namespace App\Service;

use App\Entity\Goal;

/**
 * Service for managing goal-related operations.
 */
class GoalService implements ServiceInterface
{
     /**
     * Constructor initializes the Goal entity.
     *
     * @param Goal $goal The goal entity.
     */
    public function __construct(
        private Goal $goal
    )
    {
        
    }

    public function getEntity(): Goal
    {
        return $this->goal;
    }

     /**
     * Calculates the total sum of incoming transfers related to the goal.
     *
     * @return float The total value of transfers received.
     */
    public function getTransfersIn(): float
    {
        return array_sum(array_map(fn($input) => $input->getValue(), $this->goal->getTransfers()->toArray()));
    }

     /**
     * Calculates the progress of the goal as a percentage.
     *
     * @return float The progress percentage (0-100).
     */
    public function getProgress(): float
    {
        $transfersValue = $this->getTransfersIn();
        return $transfersValue *100 / $this->goal->getValue();
    }
}