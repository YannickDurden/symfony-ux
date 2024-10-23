<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Manager\TaskManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{
    public function __construct(
        private readonly TaskManager $taskManager,
    ) {
    }

    #[Route(path: '/task', name: 'task_list', methods: ['GET'])]
    public function list(): Response
    {
        return $this->render('task/list.html.twig', [
            'tasks' => $this->taskManager->fetchAll(),
        ]);
    }

    #[Route(path: '/task/new', name: 'task_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskManager->persistAndFlush($task);

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route(path: '/task/{id}', name: 'task_show', methods: ['GET'])]
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route(path: '/task/{id}/delete', name: 'task_delete', methods: ['POST'])]
    public function remove(Task $task): Response
    {
        $this->taskManager->remove($task);

        return new Response(
            status: Response::HTTP_NO_CONTENT,
        );
    }
}
