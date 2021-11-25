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
     * @Route("/order/validate/{reference}", name="confirm_order")
     */
    public function confirm(Cart $cart, $reference): Response
    {
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
        return $this->render('order/confirm.html.twig',[
            'reference' => $reference,
        ]);
    }
}
