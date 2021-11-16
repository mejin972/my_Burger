<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditPersonalInformationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountInfoPersoController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/compte/info/perso/{id}", name="account_info_perso")
     */
    public function edit(User $user, Request $request): Response
    {
        $form = $this->createForm(EditPersonalInformationType::class,$user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$user = new User($form->getData());
            $user = $form->getData();
            
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirect($this->generateUrl('account_info', ['id' => $user->getId()]));
            //dd($user);

        }

        return $this->render('account/accountInfoPerso.html.twig',[
            'form'=>$form->createView(),
        ]);
    }
}
