<?php

namespace App\Service;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskService
{
    public function __construct(private readonly TaskRepository $repository)
    {
    }

    /**
     * @return Task[]
     */
    public function getTodayTasks(): array
    {
        return $this->repository->getTasks(date('Y-m-d'));
    }

    /**
     * @return Task[]
     */
    public function getTodayUndoneTasks(): array
    {
        return $this->repository->getTasks(date('Y-m-d'), false);
    }

    /**
     * @return Task[]
     */
    public function getTodayDoneTasks(): array
    {
        return $this->repository->getTasks(date('Y-m-d'), true);
    }

    public function doneTask(int $taskId): Task
    {
        $task = $this->repository->find($taskId);

        if (!$task) {
            throw new NotFoundHttpException('No task found with the id '.$taskId);
        }

        return $this->repository->saveTask($task, ['done' => true]);
    }

    public function undoneTask(int $taskId): Task
    {
        $task = $this->repository->find($taskId);

        if (!$task) {
            throw new NotFoundHttpException('No task found with the id '.$taskId);
        }

        return $this->repository->saveTask($task, ['done' => false]);
    }
}
