<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceControlleurController extends AbstractController
{
    #[Route('/service/controlleur', name: 'app_service_controlleur')]
    public function index(): Response
    {
        return $this->render('service_controlleur/index.html.twig', [
            'controller_name' => 'ServiceControlleurController',
        ]);
    }
}
