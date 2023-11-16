<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VehiculeRepository;

class AcceuilController extends AbstractController
{
    #[Route('/acceuil', name: 'app_acceuil')]
    public function index(): Response
    {
        return $this->render('acceuil.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    #[Route('/client', name: 'app_client', methods: ['GET'])]
    public function client(VehiculeRepository $vehiculeRepository): Response
    {
        return $this->render('vehiculeClient.html.twig', [
            'vehicules' => $vehiculeRepository->findAll(),
        ]);
    }
    #[Route('/admin', name: 'app_admin')]
    public function admin(): Response
    {
        return $this->render('baseback.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
}
