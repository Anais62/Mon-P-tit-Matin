<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangeInformationType;
use App\Form\InformationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InformationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    



    #[Route('/compte/information', name: 'app_information')]
    public function index(Request $request): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ChangeInformationType::class , $user);

        $form->handleRequest($request);
        return $this->render('account/information.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/compte/modifier-mes-information', name: 'app_information_edit')]
    public function edit(Request $request): Response
    {
        $user = $this->getUser();

        
        $form = $this->createForm( InformationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()  && $form->isValid()) {
           
            
            $this->entityManager->flush();
            return $this->redirectToRoute('app_information');

            
        }
        return $this->render('account/information_edit.html.twig',[
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}
