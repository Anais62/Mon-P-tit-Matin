<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' =>'Votre nom',
                'constraints' => new Length([
                    'min' => 2,
                    'max'=> 30
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir votre nom'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'constraints' => new Length([
                    'min' => '2',
                    'max' => '30'
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir votre prénom'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => ' Votre Email',
                'constraints' => new Length([
                    'min' => 2,
                    'max' =>60
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir votre adresse email'
                ]
            ])
            
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => new Length([
                    'min'=> 2,
                    'max'=>30
                ]),
                'invalid_message'=> 'Les mots de passent ne correspondent pas',
                'label' => 'Votre mot de passe',
                'required' => True,
                'first_options' => [
                    'label' => 'Votre mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir votre mot de passe'
                    ]
                ],
                'second_options' => ['label' => 'Confirmation du mot de passe',
                'attr' => [
                    'placeholder' => 'Merci de confirmer votre mot de passe'
                ]
                
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Confirmer mon inscription",
                'attr' => [
                    'class' => 'btn btn-dark'
                ],
                'row_attr' => [
                    'class' => 'text-center',
                ],
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
