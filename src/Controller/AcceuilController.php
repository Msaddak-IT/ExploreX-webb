<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VehiculeRepository;

class AcceuilController extends AbstractController
{
    #[Route('/acc', name: 'app')]
    public function index(): Response
    {
        return $this->render('AcceuilRes.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    #[Route('/adm', name: 'app_acceuil')]
    public function admin(): Response
    {
        return $this->render('baseback.html.twig', [
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
    #[Route('/aboutus', name: 'about')]
    public function aboutus(): Response
    {
        return $this->render('aboutus.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
}
