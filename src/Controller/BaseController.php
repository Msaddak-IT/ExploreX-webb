<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    #[Route('/', name: 'app_base')]
    public function index(): Response
    {
        return $this->render('base/index.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }
    #[Route('/basebase',name:'base_base')]
    public function showBackBase():Response
    {
        return  $this->render('backbase.html.twig');
    }
    #[Route('/maps', name: 'maps')]
    public function show_map(): Response
    {
        return $this->render('maps.html.twig');
    }


}
