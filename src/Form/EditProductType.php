<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Products;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EditProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'Nom du produit',
            ])/*
            ->add('slug',TextType::class,[
                'label' => 'Slug du produit'
            ])*/
            ->add('illustration',FileType::class,[
                'label' => 'Illustration produit',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2000k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Veillez télécharger une imge valide',
                    ])
                ]
            ])
            ->add('description',TextareaType::class,[
                'label' => 'Description du produit',
            ])
            ->add('prix',MoneyType::class,[
                'label' => 'Prix du produit',
                'currency' => 'EUR'
            ])
            ->add('a_La_Une', CheckboxType::class,[
                'required' => false,
            ])
            ->add('category',EntityType::class,[
                // looks for choices from this entity
                'class' => Category::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'name',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('submit',SubmitType::class,[
                'label' => 'Sauvegarder',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
