<?php

namespace App\Controller;

use App\Entity\Bonplan;
use App\Form\BonplanType;
use App\Repository\BonplanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bonplan')]
class BonplanController extends AbstractController
{
    #[Route('/', name: 'app_bonplan_index', methods: ['GET'])]
    public function index(BonplanRepository $bonplanRepository): Response
    {
        return $this->render('bonplan/index.html.twig', [
            'bonplans' => $bonplanRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bonplan_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bonplan = new Bonplan();
        $form = $this->createForm(BonplanType::class, $bonplan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bonplan);
            $entityManager->flush();

            return $this->redirectToRoute('app_bonplan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bonplan/new.html.twig', [
            'bonplan' => $bonplan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bonplan_show', methods: ['GET'])]
    public function show(Bonplan $bonplan): Response
    {
        return $this->render('bonplan/show.html.twig', [
            'bonplan' => $bonplan,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bonplan_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bonplan $bonplan, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BonplanType::class, $bonplan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bonplan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bonplan/edit.html.twig', [
            'bonplan' => $bonplan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bonplan_delete', methods: ['POST'])]
    public function delete(Request $request, Bonplan $bonplan, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bonplan->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bonplan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bonplan_index', [], Response::HTTP_SEE_OTHER);
    }
}
