<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface; // Importez cette classe

class AccountDeleteController extends AbstractController
{
    private $entityManager; // Ajoutez cette propriété

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/compte/supprimer', name: 'app_account_delete')]
    public function delete(Request $request, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $form = $this->createFormBuilder()
            ->add('password', PasswordType::class, [
                'label' => 'Entrez votre mot de passe pour pouvoir supprimer votre compte',
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Confirmer la suppression de mon compte",
                'attr' => [
                    'class' => 'btn btn-danger'
                ],
                'row_attr' => [
                    'class' => 'text-center',
                ],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier le mot de passe
            if ($passwordEncoder->isPasswordValid($user, $form->get('password')->getData())) {
                // Supprimer le compte
                $this->entityManager->remove($user);
                $this->entityManager->flush();
                $this->addFlash('success', 'Votre compte a été supprimé avec succès.');
                return $this->redirectToRoute('app_home');
            } else {
                $this->addFlash('danger', 'Le mot de passe est incorrect.');
            }
        }

        return $this->render('account/delete.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
//zdazda