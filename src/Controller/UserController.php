<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/users', name: 'app_user_list')]
    public function list(UserRepository $repository): Response
    {
        return $this->render('user/list.html.twig', [
            'users' => $repository->findAll(),
        ]);
    }

    
    #[Route(path:'/users/create', name: "app_user_create")]
     
    public function create(Request $request, UserPasswordHasherInterface $hash, 
    EntityManagerInterface $entityManager)
    {
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

        return $this->render('user/create.html.twig', 
                ['form' => $form->createView()]);
    }

    #[Route(path:'/users/{id}/edit', name: 'app_user_edit')]
     
    public function edit(User $user, Request $request, UserPasswordHasherInterface $hash,
    EntityManagerInterface $entityManager )
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $hash->hashPassword($user, $user->getPassword());
            $user->setPassword($password);

            $entityManager->persist($user);
            $entityManager->flush();
            
            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('app_user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }

    #[Route(path:'/users/{id}/delete', name: 'app_user_delete')]

    public function delete(User $user, EntityManagerInterface $entityManager){

        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'Le user a bien été supprimé.');

        return $this->redirectToRoute('app_user_list');

    }
}
