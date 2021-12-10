<?php

namespace App\Form;

use App\Entity\RangUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditRangUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Nom du Rang',
                'attr' => [
                    'placeholder' => 'Indiquez le nom du rang',
                ]
            ])
            ->add('condition_obtention', TextType::class,[
                'label' => " Condition d'accès au rang ", 
                'attr' => [
                    'placeholder' => 'Nombre total de point à atteindre',
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Sauvegarder',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RangUser::class,
        ]);
    }
}
