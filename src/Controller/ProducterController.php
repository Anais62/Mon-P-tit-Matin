<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProducterController extends AbstractController
{
    #[Route('/nos-partenaires', name: 'app_producter')]
    public function index(): Response
    {
        return $this->render('producter/index.html.twig');
    }
}
