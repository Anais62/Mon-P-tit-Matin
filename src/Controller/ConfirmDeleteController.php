<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConfirmDeleteController extends AbstractController
{
    #[Route('/confirmation/suppression', name: 'app_confirm_delete')]
    public function index(): Response
    {
        return $this->render('confirm_delete/index.html.twig');
    }
}
