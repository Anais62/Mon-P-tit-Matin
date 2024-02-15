<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Formule;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart): Response
    {
        
        
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->get()
        ]);
    }


    #[Route('/cart/add/{id}', name: 'app_add_to_cart')]
    public function add(Cart $cart, $id, Request $request): Response
    {
        // Récupérez les IDs de produits depuis la requête
        $productIds = $request->query->get('productIds');

        // Utilisez explode pour obtenir un tableau d'IDs de produits
        $productIdsArray = explode(',', $productIds);

        $cart->add($id, $productIdsArray);

        return $this->redirectToRoute('app_cart');
    }


    #[Route('/cart/remove', name: 'app_remove_my_cart')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();

        return $this->redirectToRoute('app_product');
    }


}
