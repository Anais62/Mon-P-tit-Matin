<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Entity\Address;

class AccountDeleteController extends AbstractController
{
    private $entityManager;
    private $tokenStorage;

    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
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
                'label' => 'Entrez votre mot de passe pour confirmer la suppression de votre compte',
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
                // Supprimer les adresses liées à l'utilisateur
                $addresses = $user->getAddresses();
                foreach ($addresses as $address) {
                    $this->entityManager->remove($address);
                }

                // Supprimer le compte
                $this->entityManager->remove($user);
                $this->entityManager->flush();

                // Déconnecter l'utilisateur
                $this->tokenStorage->setToken(null);

                $this->addFlash('success', 'Votre compte a été supprimé avec succès.');
                return $this->redirectToRoute('app_confirm_delete');
            } else {
                $this->addFlash('danger', 'Le mot de passe est incorrect.');
            }
        }

        return $this->render('account/delete.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
