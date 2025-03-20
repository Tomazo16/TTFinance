<?php 

namespace App\Controller;

use Tomazo\Router\Attribute\Route;

class IndexController
{
    #[Route('/index', name: 'index')]
    public function index()
    {

    }
}