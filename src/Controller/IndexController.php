<?php 

namespace App\Controller;

use App\Entity\Account;
use App\Service\AccountService;
use Tomazo\Router\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index()
    {

        echo $this->render('dashboard.html.php', [
            'accounts' => $this->mapEntitiesToServices('Account','findAll'),
        ]);
    }
}