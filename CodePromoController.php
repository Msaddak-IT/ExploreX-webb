<?php

namespace App\Controller;

use App\Entity\CodePromo;
use App\Form\CodePromoType;
use App\Repository\CodePromoRepository;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




#[Route('/codepromo')]
class CodePromoController extends AbstractController
{

    #[Route('/', name: 'app_code_promo_index', methods: ['GET'])]
    public function index(CodePromoRepository $codePromoRepository, Request $request,FlashyNotifier $flashy): Response
    {

        $searchTerm = $request->query->get('search');
        $codepromos = $codePromoRepository->searchCodePromos($searchTerm);
        $flashy->success('Welcome Back Admin!');

        if ($request->isXmlHttpRequest()) {
            return $this->render('code_promo/search_results.html.twig', [
                'code_promos' => $codepromos,
            ]);
        }

        return $this->render('code_promo/index.html.twig', [
            'code_promos' => $codepromos,
        ]);
    }

    #[Route('/new', name: 'app_code_promo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $codePromo = new CodePromo();
        $form = $this->createForm(CodePromoType::class, $codePromo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($codePromo);
            $entityManager->flush();
            return $this->redirectToRoute('app_code_promo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('code_promo/new.html.twig', [
            'code_promo' => $codePromo,
            'form' => $form,
        ]);

    }

    #[Route('/codepromo/{id}', name: 'app_code_promo_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(int $id, CodePromoRepository $codePromorepository): Response
    {
        $codePromo = $codePromorepository->find($id);

        if (!$codePromo) {
            throw $this->createNotFoundException('CodePromo not found');
        }

        return $this->render('code_promo/show.html.twig', [
            'code_promo' => $codePromo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_code_promo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id, CodePromoRepository $codePromoRepository, EntityManagerInterface $entityManager): Response
    {
        $codePromo = $codePromoRepository->find($id);

        if (!$codePromo) {
            throw $this->createNotFoundException('CodePromo not found');
        }

        $form = $this->createForm(CodePromoType::class, $codePromo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_code_promo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('code_promo/edit.html.twig', [
            'code_promo' => $codePromo,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_code_promo_delete', methods: ['POST'])]
    public function delete(Request $request, CodePromo $codePromo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $codePromo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($codePromo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_code_promo_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/statistics', name: 'app_code_promo_statistics', methods: ['GET'])]
    public function statistics(CodePromoRepository $codePromoRepository): Response
    {
        $expiredCodePromosCount = $codePromoRepository->countExpiredCodePromos();
        $notExpiredCodePromosCount = $codePromoRepository->countNotExpiredCodePromos();

        return $this->render('code_promo/statistics.html.twig', [
            'expiredCodePromosCount' => $expiredCodePromosCount,
            'notExpiredCodePromosCount' => $notExpiredCodePromosCount,
        ]);
    }


}
