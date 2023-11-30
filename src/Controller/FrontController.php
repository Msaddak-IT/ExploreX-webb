<?php

namespace App\Controller;

use App\Entity\Agence;
use App\Form\AgenceType;
use App\Form\Categorie;
use App\Repository\AgenceRepository; 
use App\Repository\CategorieRepository; 
use App\Repository\AssuranceRepository; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\QrcodeService;

#[Route('/front')]
class FrontController extends AbstractController
{
    #[Route('/', name: 'app_agence_index_front', methods: ['GET'])]
    public function index(AgenceRepository $agenceRepository, CategorieRepository $categorieRepository, AssuranceRepository $assuranceRepository): Response
    {
        return $this->render('front/index.html.twig', [
            'agences' => $agenceRepository->findAll(),
            'categories' => $categorieRepository->findAll(),
            'assurances' => $assuranceRepository->findAll(),
        ]);
    }

    #[Route('/qrgenerate', name: 'app_agence_qr', methods: ['GET'])]
    public function qrgenerate(AgenceRepository $agenceRepository,Request $request,QrcodeService $qr): Response
    {
        $id = $request->query->get('id');
        $agence = $agenceRepository->find($id);
        $qrres = $qr->qrcode($agence->getNomAgence(),$agence->getAdresse(),$agence->getTelephone());
        return $this->render('front/qr.html.twig', ['path' => $qrres ]);
    }

}
