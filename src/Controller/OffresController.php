<?php

namespace App\Controller;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Flashy\Flashy;
use App\Entity\Offres;
use App\Form\OffresType;
use App\Repository\OffresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\JsonResponse; 
use App\Entity\Service;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\EmailRecipientInterface;
use Symfony\Component\Notifier\NotifierInterface;


#[Route('/offres')]
class OffresController extends AbstractController
{
   
    private $flashy;

public function __construct(FlashyNotifier $flashy)
{
    $this->flashy = $flashy;
}

    #[Route('/', name: 'app_offres_index', methods: ['GET'])]
    public function index(OffresRepository $offresRepository, Request $request): Response
    {
        $sort = $request->query->get('sort', 'asc');
        dump($sort); 
        $offres = $offresRepository->findAllSortedByDate($sort);
    
        // Exemple de message flash pour succès
        $this->flashy->success('Offre créée avec succès');
    
        // Exemple de message flash pour erreur
        $this->flashy->error('Une erreur s\'est produite lors de la création de l\'offre.');
    
        return $this->render('offres/index.html.twig', [
            'offres' => $offres,
        ]);
    }

    
    #[Route('/{idOffres}/edit', name: 'app_offres_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offres $offre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OffresType::class, $offre);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            // Utilisez FlashyNotifier pour ajouter un message flash
            $this->flashy->success('L\'offre a été modifiée avec succès.');
            dump('Message flash créé avec succès.');
            return $this->redirectToRoute('app_offres_index');
        }
    
        return $this->renderForm('offres/edit.html.twig', [
            'offre' => $offre,
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'app_offres_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,MailerInterface $mailer_lassoued, FlashBagInterface $flashBag): Response
    {
        $offre = new Offres();
        $form = $this->createForm(OffresType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($offre);
            $entityManager->flush();
            dump($form->getData());
           
        // Composer l'e-mail
        $email = (new Email())
        ->from('lassoued.nour@esprit.tn')
        ->to('lassoued.nour@esprit.tn')
        ->subject('Nouvelle offre créée')
        ->html($this->renderView('offres/notification_nouvelle_offre.html.twig', [
            'offre' => $offre,
        ]), 'text/html');

    // Envoyer l'e-mail
    $mailer_lassoued->send($email);
            return $this->redirectToRoute('app_offres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('offres/new.html.twig', [
            'offre' => $offre,
            'form' => $form,
        ]);
    }
    
    public function sendEmail(MailerInterface $mailer)
    {
        // Créer l'e-mail
        $email = (new Email())
            ->from('from@example.com')
            ->to('to@example.com')
            ->subject('Hello')
            ->text('Hello, this is a test email.');

        // Envoyer l'e-mail
        $mailer->send($email);
    }
   
    #[Route('/stats', name: 'app_offres_stats', methods: ['GET'])]
    public function stats(OffresRepository $offresRepository): Response
    {
        $stats = $offresRepository->countByDestination();
        
        return $this->render('offres/satats.html.twig', [
            'stats' => $stats,
        ]);
    }
    
 


    #[Route('/{idOffres}', name: 'app_offres_delete', methods: ['POST'])]
    public function delete(Request $request, Offres $offre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offre->getIdOffres(), $request->request->get('_token'))) {
            $entityManager->remove($offre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_offres_index', [], Response::HTTP_SEE_OTHER);
    }
}
