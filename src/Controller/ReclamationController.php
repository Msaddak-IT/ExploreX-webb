<?php

namespace App\Controller;

use Twilio\Rest\Client;
use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TwilioService;
use UltraMsg\WhatsAppApi;
use MercurySeries\Flashy\FlashyNotifier;






#[Route('/reclamation')]
class ReclamationController extends AbstractController
{
 

    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(ReclamationRepository $reclamationRepository): Response
    {
        
     
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,TwilioService $twilioService): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
           
    
            $entityManager->persist($reclamation);
            $entityManager->flush();
        
            // $to = '+216 25055718'; 
            
            // $message = 'La reclamation est ajouté avec succès'; 
            // $twilioService->sendSMS($to, $message);
       
            $this->addFlash('success', 'Ton reclamation a été sauvegardé avec succés');
            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/what', name: 'whatsapp')]
    public function envoyerMessageWhatsApp($type, $nom, $date): Response
    {
        require_once __DIR__ . '/../../vendor/autoload.php';
        $ultramsg_token = "npnk7o0le9w9hkqk"; 
        $instance_id = "instance70008"; 
    
        $client = new WhatsAppApi($ultramsg_token, $instance_id);
    
        $to = "+21625055718"; 
        $body = "Bonjour,\n\nNous vous informons que votre réclamation a été modifié dans notre système. Voici les détails :\n\nUtilisateur : $nom\nType de réclamation : $type\nDate : $date\n \n\nCordialement.";
    
        $api = $client->sendChatMessage($to, $body);
    
        print_r($api); 
    
        return new Response('WhatsApp messages sent successfully!');
    }

    

    #[Route('/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
      
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $user = $reclamation->getNom();
            $Type = $reclamation->getType();
            $date = $reclamation->getDatetReclama()->format('Y-m-d'); 
            $this->envoyerMessageWhatsApp($Type, $user, $date);


            $this->addFlash('success' , 'Ton reclamation a été modifié avec succés');
            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
            
            $this->addFlash('success', 'Ton réclamation a été supprimé avec succès');
        }
    
        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/reclamation/{id}/pdf', name: 'create_pdf', methods: ['GET'])]
    public function Pdf(Reclamation $reclamation): Response
    {
        // Create TCPDF instance
        $pdf = new \TCPDF();
    
        // Set PDF content
        $pdf->AddPage(); // Add a new page to the PDF
    
        // Center the title
        $pdf->SetXY(40, 10); // Adjust the X and Y coordinates for title positioning
        $pdf->SetFont('helvetica', 'B', 20); // Définit la police en gras (Bold) avec une taille de 20 points
        $pdf->Cell(0, 10, '', 0, 1); // Ajoute un espace vide pour créer de l'espace avant le titre
        $pdf->Cell(0, 30, 'Reclamation', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 12); // Rétablit la police par défaut après le titre
        $pdf->Ln(10);
    
        // Add information
        $pdf->SetXY(10, 50); // Adjust the X and Y coordinates for the first information cell
        $pdf->Cell(0, 10, 'Nom du client ' . $reclamation->getNom(), 0, 1);
        $pdf->Ln(5);
        $pdf->Cell(0, 10, 'Type de la reclamation ' . $reclamation->getType(), 0, 1);
        $pdf->Ln(5);
        $pdf->Cell(0, 10, 'Date de reclamation: ' . $reclamation->getDatetReclama()->format('Y-m-d'), 0, 1);
        $pdf->Ln(10);
        $pdf->Cell(0, 10, 'Description : ' . $reclamation->getDescription(), 0, 1);
        $pdf->Ln(5); 
    
        // Output the PDF content
        $pdfContent = $pdf->Output('reclamation.pdf', 'S'); // Get the PDF content as a string
    
        // Create a Symfony Response with PDF content
        $response = new Response($pdfContent);
    
        // Set headers for PDF download
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment; filename="reclamation.pdf"');
    
        return $response;
}
}
