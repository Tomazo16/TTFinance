<?php 

namespace App\Service;

use App\Entity\Category;
use DateTime;

/**
 * Service for managing category-related financial calculations.
 */
class CategoryService
{
    /**
     * Constructor initializes the Category entity.
     *
     * @param Category $category The category entity.
     */
    public function __construct(
        private Category $category,
    )
    {
        
    }

    /**
     * Calculates the total expenses for a given month.
     *
     * @param DateTime $dateTime The reference date (year and month will be used for filtering).
     * @return float The total expenses for the given month.
     */
    public function getMonthlyExpenses(DateTime $dateTime): string
    {
        return array_sum(array_map(fn($input) => ($input->getDate()->format('Y-m') === $dateTime->format('Y-m')) ? $input->getValue() : 0.00 , $this->category->getExpenses()->toArray()));
    }

    /**
     * Calculates the progress of monthly expenses as a percentage of the category's budget.
     *
     * @param DateTime $dateTime The reference date (month-based calculation).
     * @return float The progress percentage (0-100) of the budget used.
     */
    public function getMonthlyProgress(DateTime $dateTime): float
    {
        $monthlyExpenses = $this->getMonthlyExpenses($dateTime);
        return round($monthlyExpenses * 100 / $this->category->getBudget(),2);
    }
}