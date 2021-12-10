<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Products;
use App\Entity\RangUser;
use App\Form\EditProductType;
use App\Form\UpdateProductType;
use App\Form\EditCategoriesType;
use App\Form\EditRangUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdminController extends AbstractController
{
    private $entityManager;
    //private $request;

    public function __construct( EntityManagerInterface $entityManager ){
        $this->entityManager = $entityManager;
        
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/admin/products", name="admin_products")
     */
    public function VoirProduct(): Response
    {
        $allProducts = $this->entityManager->getRepository(Products::class)->findAll();
        return $this->render('admin/products.html.twig',[
            'allProducts' => $allProducts,
        ]);
    }

    /**
     * @Route("/admin/category", name="admin_category")
     */
    public function VoirCategory(): Response
    {
        $allCategories = $this->entityManager->getRepository(Category::class)->findAll();
        return $this->render('admin/category.html.twig',[
            'allCategories' => $allCategories,
        ]);
    }


    /**
     * @Route("/admin/rang", name="admin_rang")
     */
    public function VoirRang(): Response
    {
        $allRang = $this->entityManager->getRepository(RangUser::class)->findAll();
        //dd($allRang);
        return $this->render('admin/rangUser.html.twig',[
            'allRangs' => $allRang,
        ]);
    }

    /**
     * @Route("/admin/edit_rang", name="admin_editRang")
     */
    public function EditRang(Request $request): Response
    {
        $rang = new RangUser;

        $form = $this->createForm(EditRangUserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
           $rang = $form->getData();

           $this->entityManager->persist($rang);
           $this->entityManager->flush();
           
           return $this->redirectToRoute('admin_rang');
        }
        
        return $this->render('admin/editRangUser.html.twig',[
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/admin/edit_newProduct", name="admin_editProduct")
     */
    public function EditProduct(Request $request, SluggerInterface $slugger): Response
    {
        $product = new Products;

        $form = $this->createForm(EditProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $cateProduct = $product->getCategory()->getName();
            //dd($cateProduct);
            $slug = $product->getName()." - ". $cateProduct;
            $product->setSlug($slug);

            /** @var UploadedFile $illustrationFile */
            $illustrationFile = $form->get('illustration')->getData();

            if ($illustrationFile) {
                $originalFilename = pathinfo($illustrationFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$illustrationFile->guessExtension();

                try {
                    $illustrationFile->move(
                        $this->getParameter('illustration_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    dd($e);
                }

                $product->setIllustration($newFilename);
            }

            //dd($product);

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_products');
        }
        return $this->render('admin/editProduct.html.twig',[
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/admin/update_Product/{slug}", name="admin_updateProduct")
     */
    public function UpdateProduct(Request $request, SluggerInterface $slugger, $slug): Response
    {
        $product = $this->entityManager->getRepository(Products::class)->findOneBySlug($slug);
        $product->setIllustration(
            new File($this->getParameter('illustration_directory').'/'. $product->getIllustration())
        );
        //dd($product);
        $form = $this->createForm(UpdateProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            /** @var UploadedFile $illustrationFile */
            $illustrationFile = $form->get('illustration')->getData();

            if ($illustrationFile) {
                $originalFilename = pathinfo($illustrationFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$illustrationFile->guessExtension();

                try {
                    $illustrationFile->move(
                        $this->getParameter('illustration_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    dd($e);
                }

                $product->setIllustration($newFilename);
            }

            //dd($product);

            $this->entityManager->flush();
            return $this->redirectToRoute('admin_products');
            
        }
        return $this->render('admin/updateProduct.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/edit_newCategory", name="admin_NewCategory")
     */
    public function NewCategory(Request $request): Response
    {
        $category = new Category;

        $form = $this->createForm(EditCategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $this->entityManager->persist($category);
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_category');
            //dd($category);
        }
        return $this->render('admin/editNewCategory.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
