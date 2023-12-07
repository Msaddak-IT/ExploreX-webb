<?php

namespace App\Controller;

use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }
    #[Route('/accueil', name: 'app_accueil')]
    public function accueil(FlashyNotifier $flashy): Response
    {
        $this->addFlash('success', 'Welcome To ExploreX. Ready for a New Adventure ?');

        return $this->render('base/index.html.twig');
    }
    // #[Route('/logout', name: 'app_loggg')]
    // public function logout(): Response
    // {
    //     return $this->render('AcceuilRes.html.twig');
    // }
}
