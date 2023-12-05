<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\Service1Type;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/serviceajouterser')]
class ServiceajouterserController extends AbstractController
{
    #[Route('/', name: 'app_serviceajouterser_index', methods: ['GET'])]
    public function index(ServiceRepository $serviceRepository): Response
    {
        return $this->render('serviceajouterser/index.html.twig', [
            'services' => $serviceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_serviceajouterser_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $service = new Service();
        $form = $this->createForm(Service1Type::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('app_serviceajouterser_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('serviceajouterser/new.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/{idService}', name: 'app_serviceajouterser_show', methods: ['GET'])]
    public function show(Service $service): Response
    {
        return $this->render('serviceajouterser/show.html.twig', [
            'service' => $service,
        ]);
    }

    #[Route('/{idService}/edit', name: 'app_serviceajouterser_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Service $service, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Service1Type::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_serviceajouterser_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('serviceajouterser/edit.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/{idService}', name: 'app_serviceajouterser_delete', methods: ['POST'])]
    public function delete(Request $request, Service $service, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getIdService(), $request->request->get('_token'))) {
            $entityManager->remove($service);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_serviceajouterser_index', [], Response::HTTP_SEE_OTHER);
    }
}
