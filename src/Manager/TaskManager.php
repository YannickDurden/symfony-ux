<?php

namespace App\Manager;

use App\Entity\Task;
use App\Repository\TaskRepository;

readonly class TaskManager
{
    public function __construct(
        private TaskRepository $taskRepository,
    ) {
    }

    public function persistAndFlush(Task $task): void
    {
        $this->taskRepository->persistAndFlush($task);
    }

    public function fetchAll(): array
    {
        return $this->taskRepository->findAll();
    }

    public function remove(Task $task): void
    {
        $this->taskRepository->removeAndFlush($task);
    }
}
