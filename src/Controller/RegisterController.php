<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordHasherInterface $hasheur): Response
    {
        $user = new User();
        $email_exist= null;
        $form = $this->createForm(InscriptionType::class,$user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $user = $form->getData();
            $passwordHash = $hasheur->hashPassword(
                $user, 
                $user->getPassword()
            );
            $user->setPassword($passwordHash);

            $email_exist = $this->entityManager->getRepository(User::class)->findByEmail($user->getEmail());

            if (!empty($email_exist)) {
               $email_exist = 1;
               settype($email_exist,'string');
            }else {
                try {
                    //code...
                    $this->entityManager->persist($user);
                    $this->entityManager->flush();
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }

            //dd($form->getData());

        }

        return $this->render('register/index.html.twig',[
            'form' => $form->createView(),
            'email_exist' => $email_exist,
        ]);
    }
}
