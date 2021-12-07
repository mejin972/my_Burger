<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/compte", name="account")
     */
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }

    /**
     * @Route("/compte/infor_compte/{id}", name="account_info")
     */
    public function voirInfo(): Response
    {
        return $this->render('account/info.html.twig');
    }

    /**
     * @Route("/compte/mes_commandes/{userId}", name="account_order")
     */
    public function voirOrder($userId): Response
    {

        $allUserOrders = $this->entityManager->getRepository(Order::class)->findByUserId($userId);
        
        return $this->render('account/order.html.twig',[
            'orders' => $allUserOrders,
        ]);
    }

    /**
     * @Route("/compte/mes_commandes/detail/{reference}", name="account_order_detail")
     */
    public function voirDetailOrder($reference): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);

        return $this->render('account/order_detail.html.twig',[
            'order' => $order,
            'reference' => $reference
        ]);
    }
   
}
