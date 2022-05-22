<?php

namespace App\Controller;

use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class TaskController extends AbstractController
{
    public function __construct(
        private readonly TaskService $service,
        private readonly SerializerInterface $serializer
    ) {
    }

    public function today(): Response
    {
        $tasks = $this->service->getTodayTasks();

        return $this->createResponse($tasks);
    }

    public function todayUndone(): Response
    {
        $tasks = $this->service->getTodayUndoneTasks();

        return $this->createResponse($tasks);
    }

    public function todayDone(): Response
    {
        $tasks = $this->service->getTodayDoneTasks();

        return $this->createResponse($tasks);
    }

    public function doneTask(int $taskId): Response
    {
        $task = $this->service->doneTask($taskId);

        return $this->createResponse($task);
    }

    public function undoneTask(int $taskId): Response
    {
        $task = $this->service->undoneTask($taskId);

        return $this->createResponse($task);
    }

    private function createResponse(mixed $data): Response
    {
        $dataSerialized = $this->serializer->serialize($data, 'json');

        return JsonResponse::fromJsonString($dataSerialized);
    }
}
