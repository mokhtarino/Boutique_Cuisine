<?php

namespace App\Controller\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function add($product)
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);
        $qty = 1;
        if (array_key_exists($product->getId(), $cart)) {
            $qty = $cart[$product->getId()]['quantity'] + 1;
        }
        $cart[$product->getId()] = ['object' => $product, 'quantity' => $qty];
        $session->set('cart', $cart);
    }

    /**
     * @return mixed
     */
    public function getCart()
    {
        return $this->requestStack->getSession()->get('cart', []);
    }

    /**
     * Remove cart
     *
     * @return mixed
     */
    public function remove(): mixed
    {
        return $this->requestStack->getSession()->remove('cart');
    }

    /**
     * Modify item quantity in cart
     *
     * @param string $id
     * @param string $qty
     * @return void
     */
    public function updateQty(string $id, string $qty)
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if (array_key_exists($id, $cart)) {
            $qty += $cart[$id]['quantity'];
            if ($qty === 0) {
                unset($cart[$id]);
            } else {
                $cart[$id] = ['object' => $cart[$id]['object'], 'quantity' => $qty];

            }
            $session->set('cart', $cart);
        }
    }

    /**
     * Get full quantity in cart
     * @return int|mixed
     */
    public function fullQuantity()
    {
        $cart = $this->getCart();
        $qty = 0;
        foreach ($cart as $product) {
            $qty += $product['quantity'];
        }
        return $qty;
    }

    /**
     * Get total TTC
     *
     * @return float|int
     */
    public function getTotalWt()
    {
        $cart = $this->getCart();
        $total = 0;
        foreach ($cart as $product) {
            $total += $product['quantity'] * $product['object']->getPriceWt();
        }
        return $total;
    }

}