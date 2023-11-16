<?php

namespace App\Controller;

use App\Entity\Offres;
use App\Form\OffresType;
use App\Repository\OffresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Service;

class AcceuilController extends AbstractController
{
    #[Route('/acceuil', name: 'app_acceuil')]
    public function index(OffresRepository $offresRepository): Response
    {
        return $this->render('listoffresclient.html.twig', [
            'offres' => $offresRepository->findAll(),
        ]);
    }
    #[Route('/admin', name: 'app_acceuil')]
    public function admin(OffresRepository $offresRepository): Response
    {
        return $this->render('baseback.html.twig', [
            'offres' => $offresRepository->findAll(),
        ]);
    }

}
