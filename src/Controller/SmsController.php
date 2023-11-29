<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\TwilioService;

class SmsController extends AbstractController
{
    #[Route('/envoyer-sms', name: 'envoyer_sms', methods: ['GET', 'POST'])]
    public function envoyerSms(Request $request, TwilioService $twilioService): Response
    {
        // Vérifier si le formulaire a été soumis
    if ($request->isMethod('POST')) {
        // Récupérer les données du formulaire
        $numeroTelephone = $request->request->get('numeroTelephone');
        $messageTexte = $request->request->get('messageTexte');
        
        // Vérifier si les données du formulaire sont présentes
        if ($numeroTelephone === null || $messageTexte === null) {
            // Afficher le message d'erreur
            return new Response('Erreur: Données du formulaire manquantes');
        }
        
        // Envoyer le SMS
        $twilioService->sendSms($numeroTelephone, $messageTexte);

        // Afficher le template avec la variable 'smssent' définie sur 'true'
        return $this->render('sms/sms.html.twig', ['smssent' => true]);
    }

    // Afficher le formulaire
    return $this->render('sms/sms.html.twig');
    }
}
