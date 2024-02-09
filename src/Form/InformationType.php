<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType; // Import correct
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TextType::class, [
            'label' => 'Votre prénom',
            'attr' => [
                'placeholder' => 'Entrez votre prénom'
            ]
        ])
        ->add('name' , TextType::class, [
            'label' => 'Votre nom',
            'attr' => [
                'placeholder' => 'Entrez votre nom'
            ]
        ])
        ->add('email' , TextType::class, [
            'label' => 'Votre email',
            'attr' => [
                'placeholder' => 'Entrez votre adresse email'
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label' => "Confirmer mes informations",
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
