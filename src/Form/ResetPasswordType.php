<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('new_password', RepeatedType::class, [
            'type' =>PasswordType::class,
            'constraints' => new Length([
                'min'=> 2,
                'max'=>30
            ]),
            'invalid_message'=> 'Les mots de passent ne correspondent pas',
            'label' => 'Votre mot de passe',
            'required' => True,
            'first_options' => [
                'label' => 'Mon nouveau mot de passe',
                'attr' => [
                    'placeholder' => 'Mon nouveau mot de passe'
                ]
            ],
            'second_options' => ['label' => 'Confirmation du nouveau mot de passe',
            'attr' => [
                'placeholder' => 'Merci de confirmer votre nouveau mot de passe'
            ]
            
            ]
            
        ])
        ->add('submit', SubmitType::class, [
            'label' => "Mettre à jour mon mot de passe",
            'attr' => [
                'class' => 'btn btn-dark w-100 '
            ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}