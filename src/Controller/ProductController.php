<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Formule;
use App\Entity\Products;
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
        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        $allProducts = $this->entityManager->getRepository(Products::class)->findAll();
        $products = [] ;
        if (!$formule) {
            return $this->redirectToRoute('app_product');
        }
        // Pour afficher seulement les produits des enfants
        if ($formule->isKid() == true) {
            foreach ($allProducts as $product) {
                if ($product->isKid()) {
                    //dump($product);
                    $products[] = $product ;

                }
            }

        }else {
            $products = $this->entityManager->getRepository(Products::class)->findAll();

        }
        //dd($products);

        return $this->render('product/show.html.twig', [
            'formule' => $formule,
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
