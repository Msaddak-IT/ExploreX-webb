<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\LocationVehicule;
use App\Repository\LocationVehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Vehicule;

class StatController extends AbstractController
{
    #[Route('/stat', name: 'app_stat')]
    public function index(): Response
    {
        return $this->render('stat/index.html.twig', [
            'controller_name' => 'StatController',
        ]);
    }


    #[Route('/statistics', name: 'app_location_vehicule_statistics', methods: ['GET'])]
    public function statisticsmarque(EntityManagerInterface $entityManager): Response
    {
        $locationRepository = $entityManager->getRepository(LocationVehicule::class);
        $locations = $locationRepository->findAll();
    
        // Statistique par CIN
        $cinCounts = [];
        foreach ($locations as $location) {
            $cin = $location->getCinClientVehicule();
            if (!isset($cinCounts[$cin])) {
                $cinCounts[$cin] = 0;
            }
            $cinCounts[$cin]++;
        }
    
        // Statistique par marque
        $marqueCount = [];
        foreach ($locations as $location) {
            $marque = $location->getVehicules()->getMarqueVehicule();
    
            if (!isset($marqueCount[$marque])) {
                $marqueCount[$marque] = 0;
            }
    
            $marqueCount[$marque]++;
        }
    
        // Récupérer tous les CIN et toutes les marques
        $allCin = array_keys($cinCounts);
        $allMarques = array_keys($marqueCount);
    
        // Renvoyer une réponse HTML avec les statistiques
        return $this->render('location_vehicule/statistics.html.twig', [
            'allCin' => $allCin,
            'allMarques' => $allMarques,
            'cinCounts' => $cinCounts,
            'marqueCount' => $marqueCount,
        ]);
    }
    
    
}





