<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/nous-contacter', name: 'app_contact')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('notice', 'Merci de nous avoir contacté. Notre équipe va vous répondre dans les meilleurs délais.');

            // Récupérer uniquement le champ "content" du formulaire
            $messageContent = $form->get('content')->getData();
            $userEmail = $form->get('email')->getData();
            $userNom = $form->get('nom')->getData();
            $userPrenom = $form->get('prenom')->getData();

            // Créer une instance de la classe Mail
            $mail = new Mail();

            // Envoyer l'e-mail avec le contenu du message
            $mail->send(
                'anais.synave@gmail.com', // Adresse e-mail de destination
                "Mon P'tit Matin",         // Objet du message
                'Vous avez reçu un nouveau message', // Corps du message,
                "<center><h3>Un client a besoin de vous !</h3></center><br><br> <strong>Prenom : </strong> $userPrenom <br><br> <strong>Nom : </strong>$userNom <br><br><strong>Adresse e-mail : </strong>$userEmail<br><br> <strong>Message</strong> : $messageContent" // Contenu du message
            
                
            );
            // Rediriger vers la même page après l'envoi du formulaire
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
