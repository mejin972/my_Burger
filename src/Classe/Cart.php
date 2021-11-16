<?php

namespace App\Classe;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class Cart{
    private $session;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session){
        $this->entityManager = $entityManager;
        $this->session = $session;
    }

    public function add($id,$quantity){
        $cart = $this->session->get('cart', []);

        if ( (!empty($cart[$id])) && (!empty($quantity)) ) {
            $cart[$id] = $quantity;
        }
        else{
            $cart[$id] = 1;
        }
        
        $this->session->set('cart', $cart);

    }

    /**
     *  Récupère le panier
     */
    public function get(){
        return $this->session->get('cart');
    }

    /**
     * Supprime le panier
     */
    public function remove(){
        return $this->session->remove('cart');
    }
}



?>