<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/users', name: 'app_user_list')]
    #[IsGranted('ROLE_ADMIN')]
    public function list(UserRepository $repository): Response
    {

        $this->isGranted('ROLE_ADMIN', $this->getUser());
        return $this->render('user/list.html.twig', [
            'users' => $repository->findAll(),
        ]);
    }


    #[Route(path: '/users/create', name: "app_user_create")]
    public function create(
        Request $request,
        UserPasswordHasherInterface $hash,
        EntityManagerInterface $entityManager
    ) {

        if ($this->getUser()) {
            return $this->redirectToRoute('app_default');
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        
       
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $hash->hashPassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setSlug($user->getUsername());

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('app_default');
        }

        return $this->render(
            'user/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    #[Route(path: '/users/{id}/edit', name: 'app_user_edit')]
    public function edit(
        User $user,
        EntityManagerInterface $entityManager
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $this->getUser());
        $this->denyAccessUnlessGranted('EDIT_ANONYME', $this->getUser() === 'anonyme');

        if ($user->getRoles()[0] === 'ROLE_ADMIN') {
            $user->setRoles(['ROLE_USER']);
        } else {
            $user->setRoles(['ROLE_ADMIN']);
        }


        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', "Le rôle a été changé");

        return $this->redirectToRoute('app_user_list');
    }

    #[Route(path: '/users/{id}/delete', name: 'app_user_delete')]
    public function delete(User $user, EntityManagerInterface $entityManager)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', $this->getUser());
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'Le user a bien été supprimé.');

        return $this->redirectToRoute('app_user_list');
    }
}
