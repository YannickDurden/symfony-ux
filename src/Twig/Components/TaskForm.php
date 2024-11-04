<?php

namespace App\Twig\Components;

use App\Form\TaskType;
use App\Entity\Task as TaskEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent(
    name: 'TaskForm',
    template: 'components/TaskForm.html.twig'
)]
final class TaskForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public ?TaskEntity $initialFormData = null;
    public string $buttonLabel;

    protected function instantiateForm(): FormInterface
    {
        $this->buttonLabel = $this->initialFormData === null ? 'Create' : 'Edit';

        return $this->createForm(TaskType::class, $this->initialFormData);
    }

    #[LiveAction]
    public function save(EntityManagerInterface $entityManager): RedirectResponse
    {
        $this->submitForm();

        /** @var TaskEntity $task */
        $task = $this->getForm()->getData();
        $entityManager->persist($task);
        $entityManager->flush();

        $this->addFlash('success', 'Task saved');

        return $this->redirectToRoute('task_list');
    }
}
