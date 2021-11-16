<?php

namespace App\Controller;

use App\Classe\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(): Response
    {
        return $this->render('cart/index.html.twig');
    }

    /**
     * @Route("/cart/{id}/{quantity}", name="add_cart")
     */
    public function add(Cart $cart, $id, $qunatity): Response
    {
        $cart->add($id, $qunatity);
        return $this->redirectToRoute("cart");
    }
}
