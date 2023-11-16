<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Form\AddReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservationsajout')]
class ReservationsajoutController extends AbstractController
{
    #[Route('/', name: 'app_reservationsajout_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservationsajout/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reservationsajout_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservations();
        $form = $this->createForm(AddReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_acceuil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservationsajout/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }
    

    #[Route('/{idreservation}', name: 'app_reservationsajout_show', methods: ['GET'])]
    public function show(Reservations $reservation): Response
    {
        return $this->render('reservationsajout/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{idreservation}/edit', name: 'app_reservationsajout_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservations $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AddReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservationsajout_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservationsajout/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{idreservation}', name: 'app_reservationsajout_delete', methods: ['POST'])]
    public function delete(Request $request, Reservations $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getIdreservation(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservationsajout_index', [], Response::HTTP_SEE_OTHER);
    }
}
