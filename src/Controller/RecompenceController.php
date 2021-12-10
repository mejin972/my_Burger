<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecompenceController extends AbstractController
{
    /**
     * @Route("compte/recompence", name="recompence")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $achatQualilifUser = $user->getOrderQualificatif();
        $maxForReward = 10;
        $pourcentProgress = ($achatQualilifUser / $maxForReward) * 100 ;
        
        return $this->render('recompence/index.html.twig',[
            'user' => $user,
            'orderQualilifUser' => $achatQualilifUser,
            'pourcentProgress' => $pourcentProgress,
            'goal' => $maxForReward,
        ]);
    }
}
