<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index')]
    public function index(UserRepository $userRepository, Request $request,FlashyNotifier $flashy): Response
    {
        $searchTerm = $request->query->get('search');
        $searchAttribute = $request->query->get('searchAttribute');

        $users = $userRepository->searchUser($searchTerm, $searchAttribute);

        $flashy->success('Welcome Back Admin!');

        if ($request->isXmlHttpRequest()) {
            return $this->render('user/search_results.html.twig', [
                'users' => $users,
            ]);
        }
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_user_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordHasher,FlashyNotifier $flashy): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the plain password
            $hashedPassword = $userPasswordHasher->encodePassword(
                $user,
                $form->get('password')->getData()
            );
            $user->setPassword($hashedPassword);
            $user->setIsVerified(true);

            $entityManager->persist($user);
            $entityManager->flush();
            $flashy->success('User Added Successfully');

            return $this->redirectToRoute('app_user_index');
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show')]
    public function show(int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_user_edit')]
    public function edit(Request $request, int $id, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index');
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $token = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete' . $user->getId(), $token)) {
            // Valid CSRF token, proceed with deletion
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success', 'User deleted successfully.');
        } else {
            // Invalid CSRF token, handle accordingly (e.g., show an error message)
            $this->addFlash('error', 'Invalid CSRF token. User not deleted.');
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }



}
