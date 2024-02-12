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

    #[Route('/formule/{slug}', name: 'app_formule')]
    public function show($slug): Response
    {
        $formule = $this->entityManager->getRepository(Formule::class)->findOneBy(['slug' => $slug]);

        if (!$formule) {
            return $this->redirectToRoute('app_product');
        }

        return $this->render('product/show.html.twig', [
            'formule' => $formule
        ]);
    }
}
