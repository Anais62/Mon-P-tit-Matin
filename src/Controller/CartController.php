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
    public function index(Cart $cart, EntityManagerInterface $entityManager, Request $request): Response
    {      
        $cartData = $cart->get();
        $cartComplete = [];       
        $orderId = $request->getSession()->get('current_order_id');       
        $nb_formule = $request->getSession()->get('nb-cart');
        
        //dd($request->getSession());
        //dd($orderId);
        dump($cartComplete);

        if ($cartData) {
             foreach ($cartData['orders'][$orderId] as $id) {
                $nb_formule-- ;
                //if ($nb_formule>=0) {

                
            $cartComplete[] = [
                'formule' => $this->entityManager->getRepository(Formule::class)->findOneById($id),
                'product' => $this->entityManager->getRepository(Products::class)->findOneById($id),
            ];
            //}
                    dump($cartComplete);

            }

        }
       
    
       dd($cartComplete);
       //dd($cartData['orders'][$orderId]);
       //dd($cartComplete);
       //dd($cartData['orders'][$orderId]['formules']);

   
        return $this->render('cart/index.html.twig',  [
            'cart' => $cartComplete,
        ]);
    }


    #[Route('/cart/add/{id}', name: 'app_add_to_cart')]
    public function add(Cart $cart, $id, Request $request): Response
    {
        $orderId = uniqid('order_');
        // Récupérez les IDs de produits depuis la requête
        $productIds = $request->query->get('productIds');

        // Utilisez explode pour obtenir un tableau d'IDs de produits
        $productIdsArray = explode(',', $productIds);
        
        $cart->add($id, $productIdsArray, $orderId );

        $request->getSession()->set('current_order_id', $orderId);
        
        return $this->redirectToRoute('app_cart');
    }


    #[Route('/cart/remove', name: 'app_remove_my_cart')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();

        return $this->redirectToRoute('app_product');
    }


}


// if (isset($cartData['orders'][$orderId]['formules'])) {
        //     foreach ($cartData['orders'][$orderId]['formules'] as $formuleData) {
        //         // Assurez-vous que $formuleData est bien un tableau associatif
        //         if (is_array($formuleData) && isset($formuleData['id'])) {
        //             $formuleId = $formuleData['id'];
    
        //             // Utilisez l'EntityManager pour récupérer les détails de la formule
        //             $formule = $entityManager->getRepository(Formule::class)->find($formuleId);
    
        //             if ($formule) {
        //                 $cartComplete[] = [
        //                     'formules' => $formule,
        //                 ];
        //             }
        //         }
        //     }
        // }