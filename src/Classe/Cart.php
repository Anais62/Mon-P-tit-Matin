<?php

namespace App\Classe;

use App\Entity\Formule;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    private $requestStack;
    private $entityManager;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }

    public function add($id, $productIdsArray )
    {
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();

        $cart = $session->get('cart', []);

        $orderId = null;

        $orderId = uniqid('order_');
        $formule = $this->entityManager->getRepository(Formule::class)->findOneById($id);

        foreach ($productIdsArray as $productId) {
                $product = $this->entityManager->getRepository(Products::class)->findOneById($productId);
                $products[] = $product;
        }
        

        $cart[$orderId] = [
            'formule' => [
                'formule' => $formule,
                'quantity' => 1,
                
            ],
            'product' => [
                'product' => $products,
                'quantity' => 1,
            ],
            'orderId' => $orderId
        ];
        
        // COMPTER LES TRUC DU PANIER

        $totalItems = 0;
        foreach ($cart as $order) {
            $totalItems += count($order['formule']);
        }
        $totalItems = $totalItems/2 ;
        $session->set('current_order_id', $orderId);
        $session->set('nb-cart', $totalItems);
        $session->set('cart', $cart);

        return $orderId;
    }

    public function get()
    {
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();

        return $session->get('cart');
    }
    
    public function remove()
    {
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();
        $session->remove('nb-cart');

        return $session->remove ('cart');
    }

    public function delete($orderId)
    {
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();
    
        $cart = $session->get('cart', []);
        
        $totalItems = $session->get('nb-cart') - 1;
        
        $session->set('nb-cart', $totalItems);



        unset($cart[$orderId]);

        return $session->set('cart', $cart);
    }
    
    public function add_quantity($orderId){
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();

        $cart = $session->get('cart', []);

        $cart[$orderId]['formule']['quantity'] = $cart[$orderId]['formule']['quantity'] + 1 ;
        $totalItems = $session->get('nb-cart') + 1;
        
        $session->set('nb-cart', $totalItems);
        //dd($cart[$orderId]['formule']['quantity']);

        return $session->set('cart', $cart);

    }
    public function decrease_quantity($orderId){
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();

        $cart = $session->get('cart', []);

        if ($cart[$orderId]['formule']['quantity'] > 1) {
            $cart[$orderId]['formule']['quantity'] = $cart[$orderId]['formule']['quantity'] - 1 ;
            $totalItems = $session->get('nb-cart') - 1;
                    
            $session->set('nb-cart', $totalItems);
            

               
     
        }else {
            unset($cart[$orderId]);
            $totalItems = $session->get('nb-cart') - 1;
                    
            $session->set('nb-cart', $totalItems);
           
        }
        
        return $session->set('cart', $cart);
        
        //dd($cart[$orderId]['formule']['quantity']);


    }

}