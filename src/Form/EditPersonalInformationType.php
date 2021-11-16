<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditPersonalInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'attr' =>[
                    'readonly' => true,
                ]
                
            ])
            ->add('prenom', TextType::class,[
                'label'=>'Votre prénom',
                //'mapped' =>false,
                'attr' =>[
                    'placeholder'=>'Votre prénom',
                ]
            ])
            ->add('nom', TextType::class,[
                'label'=>'Votre Nom de famille',
                //'mapped' =>false,
                'attr' =>[
                    'placeholder'=>'Votre Nom de famille',
                ]
            ])
            ->add('birthday', DateType::class,[
                'widget' => 'single_text',
                'label'=>'Votre date de naissance',
                //'mapped' =>false,
                
            ])
            ->add('genre',ChoiceType::class,[
                //'mapped' =>false,
                'choices' =>[
                    'Homme'=> 'H',
                    'Femme'=> 'F',
                    'Idenférent' => 'Ne sais pas',
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label'=>'Sauvegarder',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
