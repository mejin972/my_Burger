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
        return $this->render('category/menus.html.twig',[
            'allMenus' => $allMenus,
            'name' => $name
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
        return $this->render('category/menus.html.twig',[
            'allMenus' => $allBurgers,
            'name' => $name
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
        return $this->render('category/menus.html.twig',[
            'allMenus' => $allBoissons,
            'name' => $name
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
        return $this->render('category/menus.html.twig',[
            'allMenus' => $allSnacks,
            'name' => $name
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
        return $this->render('category/menus.html.twig',[
            'allMenus' => $allDesserts,
            'name' => $name
        ]);
    }
}
