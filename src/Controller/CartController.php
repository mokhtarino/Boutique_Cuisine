<?php

namespace App\Controller;

use App\Controller\Classe\Cart;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CartController extends AbstractController
{
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig', ['cart' => $cart->getCart(), 'totalWt' => $cart->getTotalWt()]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id, Cart $cart, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);
        if (!$product) {
            $this->addFlash('danger', 'Le produit n\'existe pas');
        }
        $cart->add($product);
        $this->addFlash('success', 'Le produit a bien été ajouté à votre panier');
        return $this->redirectToRoute('app_product', ['slug' => $product->getSlug()]);
    }

    #[Route('/cart/remove', name: 'app_cart_remove')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();
        $this->addFlash('success', 'Le panier a bien été vidé');
        return $this->redirectToRoute('app_home');
    }

    #[Route('/cart/update/{id}/qty/{qty}', name: 'app_cart_update_qty')]
    public function update(Cart $cart,string $id, string $qty): Response
    {
        $cart->updateQty($id, $qty);
        $this->addFlash('success', 'Le panier a bien été mis à jour');
        return $this->redirectToRoute('app_cart');
    }
}
