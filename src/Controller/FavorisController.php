<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Favoris;
use App\Entity\Products;
use App\Entity\FavorisDetail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavorisController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    
    
    /**
     * @Route("/compte/favoris", name="favoris")
     */
    public function index(): Response
    {
        if ($this->getUser()) {

            $user = $this->getUser();
            $favoris = $user->getFavoris();
            $allProductInFavoris = $favoris->getFavorisDetails()->getValues();
            $favorisProducts = [];
            foreach ($allProductInFavoris as $key) {
                $product = $this->entityManager->getRepository(Products::class)->findOneByName($key->getProduct());
                $favorisProducts[] = $product;
               
            }
    
            return $this->render('account/favoris.html.twig',[
                "allFavoris"=> $favorisProducts,
            ]);
        }
        
        
    }

    /**
     * @Route("/favoris/{userId}/{productId}", name="add_favoris")
     */
    public function add($userId, $productId): Response
    {
        if ($this->getUser() && $this->getUser()->getId() == $userId ) {
            $user = $this->getUser();
            
            $favoris = $user->getFavoris();
            $allFavorisDetail = $favoris->getFavorisDetails()->getValues();
            $favorisName = [];
            foreach ($allFavorisDetail as $key){
                $favorisName[] = $key->getProduct();
            }

            $isfav = false;

            $product = $this->entityManager->getRepository(Products::class)->findOneById($productId);
            $productName = $product->getName();

            $search = array_search($productName,$favorisName);
            if ($productName === $favorisName[$search]) {
                $favoris->removeFavorisDetail($allFavorisDetail[$search]);
                $this->entityManager->persist($favoris);
                $this->entityManager->flush();
                $isfav = true;

                return $this->redirectToRoute('favoris');
               
            }
            
            $category_product = $this->entityManager->getRepository(Category::class)->findOneById($product->getCategory()->getId());
            $date = new DateTimeImmutable;
           

           
           if($user->getFavoris()) {

                $favoris_detail = new FavorisDetail;
                $favoris_detail->setFavoris($favoris);
                $favoris_detail->setProduct($product->getName());
                $favoris_detail->setCreatedAt($date);

                $favoris->addFavorisDetail($favoris_detail);
                
                $this->entityManager->flush();

                if ($category_product->getName() === 'Sandwich') {
                    return $this->redirectToRoute('burgers_category');
                }
                if ($category_product->getName() === 'Menu') {
                    return $this->redirectToRoute('menus_category');
                }
                if ($category_product->getName() === 'Boisson') {
                    return $this->redirectToRoute('boissons_category');
                }
                if ($category_product->getName() === 'Snack') {
                    return $this->redirectToRoute('snacks_category');
                }
                if ($category_product->getName() === 'Dessert') {
                    return $this->redirectToRoute('desserts_category');
                }else {
                    return $this->redirectToRoute('favoris');
                }
            }elseif ($user->getFavoris() == null ) {
        
                $favoris = new Favoris;
                $favoris->setUser($user);

                $this->entityManager->persist($favoris);

                $favoris_detail = new FavorisDetail;
                $favoris_detail->setFavoris($favoris);
                $favoris_detail->setProduct($product->getName());
                $favoris_detail->setCreatedAt($date);

                $this->entityManager->persist($favoris_detail);
                
                $this->entityManager->flush();
                if ($category_product->getName() === 'Sandwich') {
                    return $this->redirectToRoute('burgers_category');
                }
                if ($category_product->getName() === 'Menu') {
                    return $this->redirectToRoute('menus_category');
                }
                if ($category_product->getName() === 'Boisson') {
                    return $this->redirectToRoute('boissons_category');
                }
                if ($category_product->getName() === 'Snack') {
                    return $this->redirectToRoute('snacks_category');
                }
                if ($category_product->getName() === 'Dessert') {
                    return $this->redirectToRoute('desserts_category');
                }else {
                    return $this->redirectToRoute('favoris');
                }
            }
        }

    }

    
}
