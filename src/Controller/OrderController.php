<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use DateTimeImmutable;
use App\Entity\OrderDetail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    
    /**
     * @Route("/order", name="order")
     */
    public function index(Cart $cart): Response
    {
        $date = new DateTimeImmutable;
        $reference = $date->format('dmy').'-'.uniqid();
        return $this->render('order/index.html.twig',[
            'cart' => $cart->getfull(),
            'reference' => $reference
        ]);
    }


    /**
     * @Route("/order/comfirmation/{CHECKOUT_SESSION_ID}", name="succcess_order")
     */
    public function confirm( $CHECKOUT_SESSION_ID): Response
    {

        $SUCCESS_ORDER = 1;
        
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeId([$CHECKOUT_SESSION_ID]);
        if ($order) {
            $order->setStatue($SUCCESS_ORDER);
            $this->entityManager->flush();
        }
        $refOrder = $order->getReference();
        $detailOrder = $order->getOrderDetails()->getValues();
        //dd();
        
        return $this->render('order/confirm.html.twig',[
            'CHECKOUT_SESSION_ID' => $CHECKOUT_SESSION_ID,
            'reference' => $refOrder,
            'detailOrder' => $detailOrder
        ]);
    }

    /**
     * @Route("/order/echec/{CHECKOUT_SESSION_ID}", name="echec_order")
     */
    public function echec_order($CHECKOUT_SESSION_ID): Response
    {
        $ECHEC_ORDER = 2;
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeId([$CHECKOUT_SESSION_ID]);
        if ($order) {
            $order->setStatue($ECHEC_ORDER);
            $this->entityManager->flush();
        }
        
        $refOrder = $order->getReference();
        $detailOrder = $order->getOrderDetails()->getValues();
        
        return $this->render('order/echec.html.twig',[
            'CHECKOUT_SESSION_ID' => $CHECKOUT_SESSION_ID,
            'reference' => $refOrder,
            'detailOrder' => $detailOrder
        ]);
    }

    /**
     * @Route("/order/validation/{reference}", name="validation_order")
     */
    public function validationOrder(Cart $cart, $reference): Response
    {
        $existing_order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);
        if (empty($existing_order)) {
            $date = new DateTimeImmutable;

            $order = new Order;
            $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            
            $this->entityManager->persist($order);

            foreach ($cart->getfull() as $product) {
                
                $orderDetail = new OrderDetail;
                $orderDetail->setOrderId($order);
                $orderDetail->setProduct($product['product']->getName());
                $orderDetail->setQuantity($product['quantity']);
                $orderDetail->setPrix($product['product']->getPrix());
                $orderDetail->setTotal($product['product']->getPrix() * $product['quantity']);
                
                $this->entityManager->persist($orderDetail);
            }
        
            $this->entityManager->flush();

            return $this->redirectToRoute('recapitulatif_order',array('reference'=>$reference));
        }else {
            return $this->redirectToRoute('recapitulatif_order',array('reference'=>$reference));
        }

    }

    /**
     * @Route("/order/recapitulatif/{reference}", name="recapitulatif_order")
     */
    public function recapitulatifOrder($reference): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);
        
        $orderProducts = $order->getOrderDetails()->getValues();
        
        return $this->render('order/recapitulatif_order.html.twig',[
            'reference' => $reference,
            'products_order' => $orderProducts,
        ]);
    }
}
