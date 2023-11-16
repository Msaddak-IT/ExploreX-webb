<?php

namespace App\Controller;

use App\Entity\LocationVehicule;
use App\Form\LocationVehiculeType;
use App\Repository\LocationVehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/location/vehicule')]
class LocationVehiculeController extends AbstractController
{
    #[Route('/', name: 'app_location_vehicule_index', methods: ['GET'])]
    public function index(LocationVehiculeRepository $locationVehiculeRepository): Response
    {
        return $this->render('location_vehicule/index.html.twig', [
            'location_vehicules' => $locationVehiculeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_location_vehicule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $locationVehicule = new LocationVehicule();
        $form = $this->createForm(LocationVehiculeType::class, $locationVehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($locationVehicule);
            $entityManager->flush();

            return $this->redirectToRoute('app_acceuil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('location_vehicule/new.html.twig', [
            'location_vehicule' => $locationVehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{id_loc_vehicule}', name: 'app_location_vehicule_show', methods: ['GET'])]
    public function show(LocationVehicule $locationVehicule): Response
    {
        return $this->render('location_vehicule/show.html.twig', [
            'location_vehicule' => $locationVehicule,
        ]);
    }

    #[Route('/{id_loc_vehicule}/edit', name: 'app_location_vehicule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LocationVehicule $locationVehicule, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LocationVehiculeType::class, $locationVehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_location_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('location_vehicule/edit.html.twig', [
            'location_vehicule' => $locationVehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{id_loc_vehicule}', name: 'app_location_vehicule_delete', methods: ['POST'])]
    public function delete(Request $request, LocationVehicule $locationVehicule, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$locationVehicule->getIdlocvehicule(), $request->request->get('_token'))) {
            $entityManager->remove($locationVehicule);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_location_vehicule_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
