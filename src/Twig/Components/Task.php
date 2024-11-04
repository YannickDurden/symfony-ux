<?php

namespace App\Twig\Components;

use App\Entity\Task as TaskEntity;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'Task',
    template: 'components/Task.html.twig'
)]
final class Task
{
    public TaskEntity $task;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('task');
        $resolver->setAllowedTypes('task', TaskEntity::class);

        return $resolver->resolve($data) + $data;
    }
}
