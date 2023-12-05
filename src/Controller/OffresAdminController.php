<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\Offres;



use App\Form\OffreajoutType ;
use App\Repository\OffresRepository;
use Symfony\Component\Cache\Adapter\AdapterInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class OffresAdminController extends AbstractController
{
   
    private $offreCounts = [];

#[Route('/clientoffres', name: 'app', methods: ['GET', 'POST'])]
public function index(OffresRepository $offresRepository, Request $request): Response
{
    $destination = $request->query->get('destination');

    if ($destination) {
        $offres = $offresRepository->findByDestination($destination);
    } else {
        $offres = $offresRepository->findAll();
    }

    if ($request->isXmlHttpRequest()) {
        $action = $request->request->get('action');
        $offreId = $request->request->get('offreId');

        if ($action === 'like') {
            $this->incrementOffreLikeCount($offreId);
        } elseif ($action === 'dislike') {
            $this->incrementOffreDislikeCount($offreId);
        }

        $response = [];

        foreach ($offres as $offre) {
            $likeCount = $this->getOffreLikeCount($offre->getId());
            $dislikeCount = $this->getOffreDislikeCount($offre->getId());

            $response[] = [
                'destination' => $offre->getDestination(),
                'debut' => $offre->getDebut() ? $offre->getDebut()->format('Y-m-d') : '',
                'fin' => $offre->getFin() ? $offre->getFin()->format('Y-m-d') : '',
                'prix' => $offre->getPrix(),
                'service' => $offre->getService(),
                'likes' => $likeCount,
                'dislikes' => $dislikeCount,
            ];
        }

        return new JsonResponse($response);
    }

    return $this->render('listoffresclient.html.twig', [
        'offres' => $offres,
    ]);
}


private function incrementOffreLikeCount($offreId): void
{
    if (isset($this->offreCounts[$offreId])) {
        $this->offreCounts[$offreId]['likeCount']++;
    } else {
        // Si l'offre n'a pas encore de compteur de likes, initialisez-le à 1
        $this->offreCounts[$offreId] = ['likeCount' => 1, 'dislikeCount' => 0];
    }

    // Mettez à jour les compteurs de likes et dislikes dans le serveur en mémoire
    $this->updateOffreCountsInServerMemory();
}

private function incrementOffreDislikeCount($offreId): void
{
    if (isset($this->offreCounts[$offreId])) {
        $this->offreCounts[$offreId]['dislikeCount']++;
    } else {
        // Si l'offre n'a pas encore de compteur de dislikes, initialisez-le à 1
        $this->offreCounts[$offreId] = ['likeCount' => 0, 'dislikeCount' => 1];
    }

    // Mettez à jour les compteurs de likes et dislikes dans le serveur en mémoire
    $this->updateOffreCountsInServerMemory();
}

private function updateOffreCountsInServerMemory(): void
{
    $likeCounts = [];
    $dislikeCounts = [];

    foreach ($this->offreCounts as $offreId => $counts) {
        $likeCounts[$offreId] = $counts['likeCount'];
        $dislikeCounts[$offreId] = $counts['dislikeCount'];
    }

    // Mettre à jour les compteurs dans le serveur en mémoire (par exemple, un tableau en mémoire)
    // Adapté à votre architecture spécifique

    // Exemple avec un tableau en mémoire :
    $serverMemory = [];  // Remplacez par votre structure de stockage en mémoire

    $serverMemory['likeCounts'] = $likeCounts;
    $serverMemory['dislikeCounts'] = $dislikeCounts;

    // ... Autres opérations de mise à jour dans le serveur en mémoire ...

    // Enregistrez les modifications dans la propriété $offreCounts
    foreach ($this->offreCounts as $offreId => &$counts) {
        $counts['likeCount'] = $likeCounts[$offreId];
        $counts['dislikeCount'] = $dislikeCounts[$offreId];
    };
}

private function getOffreLikeCount($offreId): int
{
    if (isset($this->offreCounts[$offreId])) {
        return $this->offreCounts[$offreId]['likeCount'];
    }

    return 0;
}

private function getOffreDislikeCount($offreId): int
{
    if (isset($this->offreCounts[$offreId])) {
        return $this->offreCounts[$offreId]['dislikeCount'];
    }

    return 0;
}



}