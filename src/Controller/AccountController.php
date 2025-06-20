<?php 

namespace App\Controller;

use App\Form\AccountForm;
use Tomazo\Router\Attribute\Route;

class AccountController extends AbstractController
{

    #[Route('/acc', name: 'accounts')]
    public function index(): void
    {

    }
    #[Route('/acc/form', name: 'accounts_form')]
    public function form(): void
    {
        $form = new AccountForm();
        
    }

    #[Route('/acc/add', name: 'account_add', methods: ['POST'])]
    public function add(): void
    {
        echo $this->render('a.html', [
            'accounts' => $this->mapEntitiesToServices('Account','findAll'),
        ]);
    }

    #[Route('/acc/edit/{id}', name: 'account_edit')]
    public function edit(int $id): void
    {

    }

    #[Route('/acc/delete/{id}', name: 'account_delete')]
    public function delete(): void
    {
        
    }
    
}