<?php

namespace App\Classe;

use App\Entity\Products;
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

        if ( (!empty($id)) && (!empty($quantity)) ) {
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

    /**
     * Supprime un produit du panier.
     */
    public function supprimer($id){
        $cart = $this->session->get('cart', []);
        if ($cart) {
            foreach ($cart as $key => $value) {
                if ($key == $id) {
                    unset($cart[$key]);
                    //dd($cart);
                }
                
            }
            
        }
    
        return $this->session->set('cart', $cart); // et apres delete on doit set le array modifier
    }

    /**
     * 
     *
     * 
     */
    public function getfull(){
        $cartComplet = [];

        /* if() rajouter car error inopiner du foreach sur panier vide*/
        if ($this->get()) {

           /* $this->get() than $cart->get() because we are in same class no need variable here*/
            foreach ($this->get() as $id => $quantity) {
                 /* secure la requete au cas ou l'utilisateur tape un id qui n'existe pas dans l'url*/   
                $product_object = $this->entityManager->getRepository(Products::class)->findOneById($id);
                if (!$product_object) {
                    $this->supprimer($id);
                    continue; /* dans se cas le systeme passera au produit suivant sans affectuer le faux produit*/
                }

                $cartComplet[] = [
                    'product' => $product_object,
                    'quantity' => $quantity,
                ];
            }
        }
        

        return $cartComplet;
    }
}



?>