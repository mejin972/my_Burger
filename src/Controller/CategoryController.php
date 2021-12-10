<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/category/menus", name="menus_category")
     */
    public function allMenus(): Response
    {
        $name = "Menu";
        $category = $this->entityManager->getRepository(Category::class)->findOneByName($name);
        $allMenus = $this->entityManager->getRepository(Products::class)->findByCategory($category);
        $isFavoris = null;
           
        if ($allMenus && $this->getUser()) {

            $user = $this->getUser();
            $userFavDetail = $user->getFavoris()->getFavorisDetails()->getValues();
            $max = count($userFavDetail);
            $nameFav = [];
            
            foreach ($allMenus as $key => $value) {
                $burgerName[] = $value->getName();
                //dd($burgerName);
                for ($i=0; $i < $max ; $i++) { 
                    //dump($userFavDetail[$i]->getProduct());
                    if( !in_array($userFavDetail[$i]->getProduct(),$nameFav) ){
                        $nameFav[] = $userFavDetail[$i]->getProduct();
                    }

                    if ($burgerName[$key] === $nameFav[$i]) {
                        //dd($burgerName[$key]);
                        $isFavoris[] = $burgerName[$key];
                    }
                } 
            }
        }

        return $this->render('category/menus.html.twig',[
            'allMenus' => $allMenus,
            'name' => $name,
            'fav' => $isFavoris
        ]);
    }

    /**
     * @Route("/category/burgers", name="burgers_category")
     */
    public function allBurgers(): Response
    {
        $name = "Sandwich";
        $category= $this->entityManager->getRepository(Category::class)->findOneByName($name);
        $allBurgers = $this->entityManager->getRepository(Products::class)->findByCategory($category);
        $isFavoris = null;
           
        if ($allBurgers && $this->getUser()) {

            $user = $this->getUser();
            if (!empty($user->getFavoris())) {
                $userFavDetail = $user->getFavoris()->getFavorisDetails()->getValues();
            }
            if (!empty($userFavDetail)) {
                $max = count($userFavDetail);
                $nameFav = [];
            
                foreach ($allBurgers as $key => $value) {
                    $burgerName[] = $value->getName();
                    //dd($burgerName);
                    for ($i=0; $i < $max ; $i++) { 
                        //dump($userFavDetail[$i]->getProduct());
                        if( !in_array($userFavDetail[$i]->getProduct(),$nameFav) ){
                            $nameFav[] = $userFavDetail[$i]->getProduct();
                        }
                        
                        if ($burgerName[$key] === $nameFav[$i]) {
                            
                            $isFavoris[] = $burgerName[$key];
                        }
                        
                    } 
                }
            }
            
            
        }
          
        return $this->render('category/menus.html.twig',[
            'allMenus' => $allBurgers,
            'name' => $name,
            'fav' => $isFavoris
        ]);
    }

    /**
     * @Route("/category/boissons", name="boissons_category")
     */
    public function allBoissons(): Response
    {
        $name = "Boisson";
        $category = $this->entityManager->getRepository(Category::class)->findOneByName($name);
        $allBoissons = $this->entityManager->getRepository(Products::class)->findByCategory($category);
        $isFavoris = null;
           
        if ($allBoissons && $this->getUser()) {

            $user = $this->getUser();
            $userFavDetail = $user->getFavoris()->getFavorisDetails()->getValues();
            $max = count($userFavDetail);
            $nameFav = [];
            
            foreach ($allBoissons as $key => $value) {
                $burgerName[] = $value->getName();
                //dd($burgerName);
                for ($i=0; $i < $max ; $i++) { 
                    //dump($userFavDetail[$i]->getProduct());
                    if( !in_array($userFavDetail[$i]->getProduct(),$nameFav) ){
                        $nameFav[] = $userFavDetail[$i]->getProduct();
                    }

                    if ($burgerName[$key] === $nameFav[$i]) {
                        //dd($burgerName[$key]);
                        $isFavoris[] = $burgerName[$key];
                    }
                } 
            }
        }
        
        return $this->render('category/menus.html.twig',[
            'allMenus' => $allBoissons,
            'name' => $name,
            'fav' => $isFavoris
        ]);
    }

    /**
     * @Route("/category/snacks", name="snacks_category")
     */
    public function allnacks(): Response
    {
        $name = "Snack";
        $category = $this->entityManager->getRepository(Category::class)->findOneByName($name);
        $allSnacks = $this->entityManager->getRepository(Products::class)->findByCategory($category);
        $isFavoris = null;
           
        if ($allSnacks && $this->getUser()) {

            $user = $this->getUser();
            $userFavDetail = $user->getFavoris()->getFavorisDetails()->getValues();
            $max = count($userFavDetail);
            $nameFav = [];
            //dd($userFavDetail);
            foreach ($allSnacks as $key => $value) {
                $burgerName[] = $value->getName();
               
                //dd($burgerName);
                for ($i=0; $i < $max ; $i++) { 
                    //dd($userFavDetail[$i]->getProduct());
                    if( !in_array($userFavDetail[$i]->getProduct(),$nameFav) ){
                        $nameFav[] = $userFavDetail[$i]->getProduct();
                    }
                    
                    if ($burgerName[$key] === $nameFav[$i]) {
                        //dd($burgerName[$key]);
                        $isFavoris[] = $burgerName[$key];
                    }
                } 
            }
            
        }
        
        return $this->render('category/menus.html.twig',[
            'allMenus' => $allSnacks,
            'name' => $name,
            'fav' => $isFavoris
        ]);
    }

    /**
     * @Route("/category/desserts", name="desserts_category")
     */
    public function allDesserts(): Response
    {
        $name = "Dessert";
        $category = $this->entityManager->getRepository(Category::class)->findOneByName($name);
        $allDesserts = $this->entityManager->getRepository(Products::class)->findByCategory($category);
        $isFavoris = null;
           
        if ($allDesserts && $this->getUser()) {

            $user = $this->getUser();
            $userFavDetail = $user->getFavoris()->getFavorisDetails()->getValues();
            $max = count($userFavDetail);
            $nameFav = [];
            
            foreach ($allDesserts as $key => $value) {
                $burgerName[] = $value->getName();
                //dd($burgerName);
                for ($i=0; $i < $max ; $i++) { 
                    //dump($userFavDetail[$i]->getProduct());
                    if( !in_array($userFavDetail[$i]->getProduct(),$nameFav) ){
                        $nameFav[] = $userFavDetail[$i]->getProduct();
                    }

                    if ($burgerName[$key] === $nameFav[$i]) {
                        //dd($burgerName[$key]);
                        $isFavoris[] = $burgerName[$key];
                    }
                } 
            }
        }

        return $this->render('category/menus.html.twig',[
            'allMenus' => $allDesserts,
            'name' => $name,
            'fav' => $isFavoris
        ]);
    }
}
