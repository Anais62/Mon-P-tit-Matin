<?php

namespace App\Controller;

use App\Entity\Producter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProducterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/nos-partenaires', name: 'app_producter')]
    public function index(): Response
    {
        $producter = $this->entityManager->getRepository(Producter::class)->findAll();

        return $this->render('producter/index.html.twig', [
            'producters' => $producter
        ]);
    }
}
