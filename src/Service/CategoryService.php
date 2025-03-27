<?php 

namespace App\Service;

use App\Entity\Category;
use DateTime;

class CategoryService
{
    public function __construct(
        private Category $category,
    )
    {
        
    }

    public function getMonthlyExpenses(DateTime $dateTime): string
    {
        return array_sum(array_map(fn($input) => ($input->getDate()->format('Y-m') === $dateTime->format('Y-m')) ? $input->getValue() : 0.00 , $this->category->getExpenses()->toArray()));
    }

    public function getMonthlyProgress(DateTime $dateTime): float
    {
        $monthlyExpenses = $this->getMonthlyExpenses($dateTime);
        return round($monthlyExpenses * 100 / $this->category->getBudget(),2);
    }
}