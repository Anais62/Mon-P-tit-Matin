<?php

namespace App\Controller;

use App\Entity\Formule;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/nos-produits', name: 'app_product')]
    public function index(): Response
    {
        $formule = $this->entityManager->getRepository(Formule::class)->findAll();

        return $this->render('product/index.html.twig', [
            'formule' => $formule
        ]);
    }
}
