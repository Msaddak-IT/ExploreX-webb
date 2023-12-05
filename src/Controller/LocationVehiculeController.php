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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;



#[Route('/location/vehicule')]
class LocationVehiculeController extends AbstractController
{
    #[Route('/', name: 'app_location_vehicule_index', methods: ['GET'])]
    public function index(LocationVehiculeRepository $locationVehiculeRepository, Request $request): Response
    {
        $sort = $request->query->get('sort');
        $locationVehicules = $locationVehiculeRepository->findAllSortedByPickupDate($sort);

    return $this->render('location_vehicule/index.html.twig', [
        'location_vehicules' => $locationVehicules,
    ]);
    }

    #[Route('/new', name: 'app_location_vehicule_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, LocationVehiculeRepository $locationVehiculeRepository): Response
{
    $locationVehicule = new LocationVehicule();
    $form = $this->createForm(LocationVehiculeType::class, $locationVehicule);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Ajoutez ici la logique de vérification de disponibilité du véhicule

        // Supposez que $isAvailable soit un booléen indiquant la disponibilité
        $isAvailable = $locationVehiculeRepository->isVehicleAvailable(
            $locationVehicule->getVehicules()->getMatricule(),
            $locationVehicule->getPickupVehicule(),
            $locationVehicule->getReturnVehicule()
        );

        if ($isAvailable) {
            // Enregistrez la location du véhicule
            $entityManager->persist($locationVehicule);
            $entityManager->flush();

            return $this->redirectToRoute('app_location_historique', [
                'cin_client_vehicule' => $locationVehicule->getCinclientvehicule(),
            ], Response::HTTP_SEE_OTHER);
        } else {
            // Ajoutez un message flash pour indiquer que le véhicule n'est pas disponible
            $this->addFlash('error', 'The chosen vehicle is already rented for these dates. Please choose another vehicle or change dates.');
        }

        return $this->redirectToRoute('app_location_vehicule_new');
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

    #[Route('/historique/{cin_client_vehicule}', name: 'app_location_historique', methods: ['GET'])]
     public function historique($cin_client_vehicule, LocationVehiculeRepository $rep): Response
    {
    // Vous pouvez utiliser $cinClient pour filtrer les réservations par client
    $locations = $rep->findBy(['cin_client_vehicule' => $cin_client_vehicule]);
        
            // Ajoutez un message flash pour indiquer que la location a été enregistrée
            $this->addFlash('success', 'Your location has been created !');
    return $this->render('location_vehicule/historiqueLocation.html.twig', [
        'locations' => $locations,
    ]);
    }
    
     
     #[Route("/calculate-amount", name:"calculate_amount", methods:["POST"])]
     
    public function calculateAmount(Request $request): Response
    {$form = $this->createForm(LocationVehiculeType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $dureeLoc = $data['duree_loc_vehicule'];
    
            // Effectuer le calcul du montant
            $dureeInt = (int)preg_replace('/[^0-9]/', '', $dureeLoc);
            $montant = $dureeInt * 120;
    
            // Mettre à jour le champ "montantLocation"
            $data['montantLocation'] = $montant;
            $form->setData($data);
        }
    
        return $this->render('location_vehicule/new.html.twig', [
            'form' => $form->createView(),
        ]);  
    }
    

}

    
       
    
    
