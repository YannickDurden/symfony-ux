<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Task;
use App\Form\CommentType;
use App\Manager\CommentManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
// use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\Turbo\TurboBundle;

class CommentController extends AbstractController
{
    #[Route(path: '/comment/{task}', name: 'comment_task', methods: ['POST', 'GET'])]
    public function create(
        Request $request,
        Task $task,
        CommentManager $commentManager,
        HubInterface $hub
    ): Response {
        $comment = new Comment();
        $comment->setTask($task);

        $form = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('comment_task', ['task' => $task->getId()]),
        ]);
        $emptyForm = clone $form;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentManager->persistAndFlush($comment);

            /*$hub->publish(new Update(
                'task',
                $this->renderView('broadcast/comment.stream.html.twig', [
                    'comment' => $comment,
                ])
            ));*/

            /*return $this->render('comment/add_comment_button.html.twig', [
                'task' => $task,
            ]);*/

            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

            return $this->renderBlock(
                'task/show.html.twig',
                'new_comment',
                [
                    'comment' => $comment,
                    'form' => $emptyForm,
                ]
            );
        }

        return $this->render('comment/create.html.twig', [
            'form' => $form,
            'task' => $task
        ]);
    }

    #[Route(path: '/comment/remove/{id}', name: 'comment_remove', methods: ['POST'])]
    public function remove(
        Request $request,
        Comment $comment,
        CommentManager $commentManager
    ): Response {
        $commentManager->removeAndFlush($comment);

        $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

        return $this->renderBlock('task/show.html.twig', 'remove_comment', ['comment' => $comment]);
    }
}
