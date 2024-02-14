<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(): Response
    {
        return $this->render('cart/index.html.twig');
    }

    #[Route('/cart/add/{id}', name: 'app_add_to_cart')]
    public function add($id, Request $request): Response
    {
        // Récupérez les IDs de produits depuis la requête
        $productIds = $request->query->get('productIds');

        // Utilisez explode pour obtenir un tableau d'IDs de produits
        $productIdsArray = explode(',', $productIds);

        // Affichez les valeurs pour le débogage
        dd($id, $productIdsArray);
    }


}
