<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\Offres;



use App\Form\OffreajoutType ;
use App\Repository\OffresRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class OffresAdminController extends AbstractController
{
    #[Route('/clientoffres', name: 'app', methods: ['GET'])]
    public function index(OffresRepository $offresRepository): Response
    {
        return $this->render('listoffresclient.html.twig', [
            'offres' => $offresRepository->findAll(),
        ]);
    }
}