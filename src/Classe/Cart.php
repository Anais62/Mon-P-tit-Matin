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

    public function add($id, $productIdsArray)
    {
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();

        $cart = $session->get('cart', [
            'formules' => [],
            'products' => [],
        ]);
    
            // Si l'ID appartient à une formule
            if (!empty($cart['formules'][$id])) {
                $cart['formules'][$id]++;
            } else {
                $cart['formules'][$id] = 1;
            }

            // Traiter chaque élément de $productIdsArray individuellement
            foreach ($productIdsArray as $productId) {
                if (!isset($cart['products'][$productId])) {
                    $cart['products'][$productId] = 1;
                } else {
                    $cart['products'][$productId]++;
                }
            }

        
        
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

        return $session->remove('cart');
    }
}