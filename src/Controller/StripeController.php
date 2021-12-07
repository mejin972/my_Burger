<?php

namespace App\Controller;

use App\Classe\Cart;
use Stripe\Stripe;
use App\Entity\Order;
use App\Entity\Products;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    
    private $entityManager;
   

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session){
        $this->entityManager = $entityManager;
        $this->session = $session;
    }

    /**
     * @Route("order/create_checkout_session_stripe/{reference}", name="stripe_creat_session")
     */
    public function index($reference, Cart $cart): Response
    {
        
        $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);
        $product_for_stripe = [];
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';

        foreach ($order->getOrderDetails()->getValues() as $produit ) {
           
           $product_object = $this->entityManager->getRepository(Products::class)->findOneByName($produit->getProduct());

            $product_for_stripe[] = [
                'price_data' =>
                [
                    'currency' => 'eur',
                    'unit_amount' => ( $produit->getPrix() * 100),
                    'product_data' => [
                        'name' => $produit->getProduct(),
                        /*'images' => ['uploads/creaProduct/'.$product['product']->getIllustration()], En chemin d'accès   */
                        'images' => [ $YOUR_DOMAIN.'/uploads/creaProduct/'.$product_object->getIllustration()],// Version URL d'accès.
                    ],  
                ],
                'quantity' => $produit->getQuantity(),
                //dd($product->getQuantity()),
            ];
        }
       

        Stripe::setApiKey('sk_test_51K03PhJ5R4QCwesL5bzlnteQXPMeptQedfVK40dzLVsQ2ewtad9JyCIK3V1BYdIhsaWkZYBHcs3Ksi15dJEWEXdE00Z4DapK4o');

        if ($order) {
            
            $checkoutSession = Session::create([
                'customer_email'=> $this->getUser()->getEmail(),
                'payment_method_types' => ['card'],
                'line_items' =>
                [
                    $product_for_stripe
                ],
                'mode' => 'payment',
                'success_url' => $YOUR_DOMAIN . '/order/comfirmation/{CHECKOUT_SESSION_ID}',
                'cancel_url' => $YOUR_DOMAIN . '/order/echec/{CHECKOUT_SESSION_ID}',
            ]);
           

            $order->setStripeSessionsId($checkoutSession->id);
            $cart->remove();
            
            
            $this->entityManager->flush();

            // Set your secret key. Remember to switch to your live secret key in production.
            // See your keys here: https://dashboard.stripe.com/apikeys
            
            /*    
            function print_log($val) {
            return file_put_contents('php://stderr', print_r($val, TRUE));
            }

            $payload = @file_get_contents('php://input');
            */
            // For now, you only need to log the webhook payload so you can see
            // the structure.
            //print_log($payload);

           
            return $this->redirect($checkoutSession->url,302);

        }else {
            $error = 'something get wrong';
            return $this->redirectToRoute('recapitulatif_order', array('reference' => $reference));
        }
       
    }
}
