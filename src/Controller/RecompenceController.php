<?php

namespace App\Controller;

use App\Entity\RangUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecompenceController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("compte/recompence", name="recompence")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        if ($user) {
            $pointUser = $user->getPoint();
            $rangUser = $user->getRangUser()->getName();
            $actuelRangUserPointObtention = $user->getRangUser()->getConditionObtention();

            if ($user->getRangUser()->getId() < 5) {
                $nextRangUserId = $user->getRangUser()->getId() + 1;
                $nextRangUser = $this->entityManager->getRepository(RangUser::class)->findOneById($nextRangUserId);
                $nextRangUserConditionObtention = $nextRangUser->getConditionObtention();
                
            }
            
            if ($pointUser >= "500") {
                $p = "500";
                $newRangUser = $this->entityManager->getRepository(RangUser::class)->findOneByPointUser($p);
                
                $user->setRangUser($newRangUser);
                $rangUser = $user->getRangUser()->getName();
                
                $this->entityManager->flush();
            }
            if ($pointUser >= "1500") {
                $p = "$1500";
                $newRangUser = $this->entityManager->getRepository(RangUser::class)->findOneByPointUser($p);
                $user->setRangUser($newRangUser);
                $rangUser = $user->getRangUser()->getName();
                
                $this->entityManager->flush();
            }
            if ($pointUser >= "3500") {
                $p = "$3500";
                $newRangUser = $this->entityManager->getRepository(RangUser::class)->findOneByPointUser($p);
                $user->setRangUser($newRangUser);
                $rangUser = $user->getRangUser()->getName();
                
                $this->entityManager->flush();
            }
            if ($pointUser >= "5500") {
                $p = "$5500";
                $newRangUser = $this->entityManager->getRepository(RangUser::class)->findOneByPointUser($p);
                $user->setRangUser($newRangUser);
                $rangUser = $user->getRangUser()->getName();
                
                $this->entityManager->flush();
            }
        }else {
            return $this->redirectToRoute('app_login');
        }
        $achatQualilifUser = $user->getOrderQualificatif();
        $maxForReward = 10;
        $pourcentProgressAchatQualif = ($achatQualilifUser / $maxForReward) * 100 ;
        $pourcentProgressNextRang = ($pointUser / $nextRangUserConditionObtention) * 100;
        //dd($nextRangUser);
        return $this->render('recompence/index.html.twig',[
            'user' => $user,
            'orderQualilifUser' => $achatQualilifUser,
            'pourcentProgressAchatQualif' => $pourcentProgressAchatQualif,
            'goal' => $maxForReward,
            'rangUser' => $rangUser,
            'nextRangUser' => $nextRangUser->getName(),
            'nombrePointObtention' => $nextRangUserConditionObtention - $pointUser,
            'actuelRangUserPointObtention' => $actuelRangUserPointObtention,
            'pointUser' => $pointUser,
            'nextRangUserPointObtention' => $nextRangUserConditionObtention,
            'pourcentProgressNextRang' => $pourcentProgressNextRang
        ]);
    }
}
