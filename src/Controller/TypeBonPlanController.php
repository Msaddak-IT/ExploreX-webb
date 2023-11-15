<?php

namespace App\Controller;

use App\Entity\TypeBonPlan;
use App\Form\TypeBonPlanType;
use App\Repository\TypeBonPlanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/typebonplan')]
class TypeBonPlanController extends AbstractController
{
    #[Route('/', name: 'app_type_bon_plan_index', methods: ['GET'])]
    public function index(TypeBonPlanRepository $typeBonPlanRepository): Response
    {
        return $this->render('type_bon_plan/index.html.twig', [
            'type_bon_plans' => $typeBonPlanRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_bon_plan_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeBonPlan = new TypeBonPlan();
        $form = $this->createForm(TypeBonPlanType::class, $typeBonPlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeBonPlan);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_bon_plan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_bon_plan/new.html.twig', [
            'type_bon_plan' => $typeBonPlan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_bon_plan_show', methods: ['GET'])]
    public function show(TypeBonPlan $typeBonPlan): Response
    {
        return $this->render('type_bon_plan/show.html.twig', [
            'type_bon_plan' => $typeBonPlan,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_bon_plan_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeBonPlan $typeBonPlan, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeBonPlanType::class, $typeBonPlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_bon_plan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_bon_plan/edit.html.twig', [
            'type_bon_plan' => $typeBonPlan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_bon_plan_delete', methods: ['POST'])]
    public function delete(Request $request, TypeBonPlan $typeBonPlan, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeBonPlan->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typeBonPlan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_bon_plan_index', [], Response::HTTP_SEE_OTHER);
    }
}
