<?php

namespace App\Classe;
 
use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function add($id, $productIdsArray, $orderId)
    {
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();

        $cart = $session->get('cart', []);

        // Générez un nouvel identifiant unique pour la commande
        // $orderId = uniqid('order_');


        $cart['orders'][$orderId] = [
                'formule' => [
                    'id' => $id,
                ],        
                'products' => [
                    'id' => $productIdsArray,
                ]
            
        ];
        
        // COMPTER LES TRUC DU PANIER

        $totalItems = 0;
        foreach ($cart['orders'] as $order) {
            $totalItems += count($order['formule']);
        }
        $session->set('nb-cart', $totalItems);
        $session->set('cart', $cart);

    }


    public function get()
    {
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();

        return $session->get('cart', []);
    }

    public function remove()
    {
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();
        $session->remove('nb-cart');
        return $session->remove('cart');
    }

  

}




// public function add($id, $productIdsArray)
// {
//     $request = $this->requestStack->getCurrentRequest();
//     $session = $request->getSession();

//     $cart = $session->get('cart', []);

//     // Générez un nouvel identifiant unique pour la commande

//     $orderId = uniqid('order_');


//     $cart['orders'][$orderId] = [
//             'formules', [
//                 'id' => $id,
//             ],        
//             'products', [
//                 'id' => $productIdsArray,
//             ]
        
//     ];

//     dd($cart);

//     $session->set('cart', $cart);

// }