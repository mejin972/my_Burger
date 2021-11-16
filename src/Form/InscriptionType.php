<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse mail',
                'attr'=>[
                    'placeholder' => 'exemple@gmail.com'
                ]
            ])
            ->add('password',RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'La comfirmation de votre mot de passe ne correspond pas au mot de passe donné.',
                'label' => 'Mot de passe',
                'required'=>true,
                'first_options'=>[
                    'label'=>'Votre mot de passe',
                    'attr'=>[
                        'placeholder' => 'Veuillez saisir votre mot de passe',
                    ]
                ],
                'second_options'=>[
                    'label'=>'Comfirmer votre mot de passe',
                    'attr'=>[
                        'placeholder' => 'Veuillez comfirmer votre mot de passe',
                    ]
                ],
            ])
            ->add('submit',SubmitType::class,[
                'label' => 'Valider'
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
