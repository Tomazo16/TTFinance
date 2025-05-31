<?php 

namespace App\Controller;

use Tomazo\Router\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): void
    {

        echo $this->render('dashboard.html.php', [
            'accounts' => $this->mapEntitiesToServices('Account','findAll'),
            'budgets' =>$this->mapEntitiesToServices('Category', 'findAll'),
            'goals' => $this->mapEntitiesToServices('Goal', 'findAll'),
            'expenses' => $this->mapEntitiesToServices('Expense', 'findAll'),
            'incomes' => $this->mapEntitiesToServices('Income', 'findAll'),
            'trnasfers' => $this->mapEntitiesToServices('Transfer', 'findAll'),
            'recurringPayments' => $this->mapEntitiesToServices('RecurringPayment', 'findAll'),
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(int $id)
    {

        echo $this->render('a.html', [
            'accounts' => $this->mapEntitiesToServices('Account','findAll'),
        ]);
    }
}