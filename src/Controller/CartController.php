<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Products;
use App\Entity\Formule;
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
    public function index(Cart $cart, Request $request) : Response
    {
        // $orderId = uniqid('orderId_');

        // $cartComplete = [];

        // foreach ($cart->get() as $id) {
        //     $formule =  $this->entityManager->getRepository(Formule::class)->findOneById($id['formule']['id']);

        //     $product = [];
        //     $products = [];

        //     foreach ($id['product']['id'] as $productId) {
        //         $product = $this->entityManager->getRepository(Products::class)->findOneById($productId);
        //         $products[] = $product;
        //     }

        //     $cartComplete[] = [
        //         'formule' => $formule,           
        //         'product' => $products,
        //         'quantity' => $id['formule']['quantity'],
        //         'productQuantity' => $id['product']['quantity'],
        //         'orderId' => $orderId
        //     ];

        // }

        return $this->render('cart/index.html.twig', [
            'cart' =>$cart->get()
        ]);
    }

    #[Route('/cart/add/{id}/{productIdsArray}', name: 'app_add_to_cart')]
    public function add(Cart $cart, $id, $productIdsArray) : Response
    {
        $productIds = explode(',', $productIdsArray);

        $cart->add($id, $productIds);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove', name: 'app_remove_my_cart')]
    public function remove(Cart $cart) : Response
    {
        $cart->remove();

        return $this->redirectToRoute('app_product');
    }

    #[Route('/cart/delete/{orderId}', name: 'app_delete_to_cart')]
    public function delete(Cart $cart, $orderId) : Response
    {

        $cart->delete($orderId);

        return $this->redirectToRoute('app_cart');
    }

}