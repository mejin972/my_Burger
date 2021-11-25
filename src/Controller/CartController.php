<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session){
            $this->entityManager = $entityManager;
            $this->session = $session;
    }

    /**
     * @Route("/mon-panier", name="cart")
     */
    public function index(Cart $cart): Response
    {
        
        //dump($this->session->get('cart'));
        return $this->render('cart/index.html.twig',[
            'cart' => $cart->getfull(),
        ]);
    }

    /**
     * @Route("/cart/{id}/{quantity}", name="add_cart")
     */
    public function add(Cart $cart, $id, $quantity): Response
    {

        $cart->add($id, $quantity);
        return $this->redirectToRoute("cart");
    }

    /**
     * @Route("/mon-panier/suprrimer/{id}", name="delete_from_cart")
     */
    public function deleteToCart(Cart $cart, $id): Response
    {
        $product_delete = $this->entityManager->getRepository(Products::class)->findOneById($id);
        $name_product = $product_delete->getName();
        $cart->supprimer($id);
        $this->addFlash(
            'notification_supp',
            $name_product.' à bien été supprimé de votre panier.',
        );
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/remove", name="delete_cart")
     */
    public function removeCart(Cart $cart): Response
    {
        $cart->remove();
        return $this->redirectToRoute("cart");
    }
}

