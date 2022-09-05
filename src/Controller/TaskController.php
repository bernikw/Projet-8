<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;

class TaskController extends AbstractController
{
    #[Route(path: '/tasks', name: 'app_task_list')]
    public function list(TaskRepository $repository): Response
    {
        return $this->render('task/list.html.twig', [
            'tasks' =>  $repository->findBy(['isDone' => 0]),
        ]);
    }


    #[Route(path: '/tasks/completed', name: 'app_task_completed')]
    public function listClosed(TaskRepository $repository)
    {
        return $this->render('task/listCompleted.html.twig', ['tasks' => $repository->findBy(['isDone'=>1])]);
    }

    #[Route(path: '/tasks/create', name: 'app_task_create')]

    public function create(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task->setSlug($slugger->slug($task->getTitle()));
            $task->setUser($this->getUser());
            $entityManager->persist($task);
            $entityManager->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('app_task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }


    #[Route(path: '/tasks/{id}/edit', name: 'app_task_edit')]

    public function edit(Task $task, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($task);
            $entityManager->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('app_task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }


    #[Route(path: '/tasks/{id}/toggle', name: 'app_task_toggle')]

    public function toggleTask(Task $task, EntityManagerInterface $entityManager)
    {
        $task->toggle(!$task->getIsDone());
        $entityManager->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('app_task_list');
    }


    #[Route(path: '/tasks/{id}/delete', name: 'app_task_delete')]

    public function deleteTaskAction(Task $task, EntityManagerInterface $entityManager)
    {

        $entityManager->remove($task);
        $entityManager->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('app_task_list');
    }
}
