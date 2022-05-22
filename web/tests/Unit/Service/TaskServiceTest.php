<?php

namespace App\Tests\Unit\Service;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Service\TaskService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @covers \App\Service\TaskService
 */
class TaskServiceTest extends TestCase
{
    private TaskService $service;

    private MockObject|TaskRepository $repository;

    public function testGetTodayTasks()
    {
        $this->repository->expects($this->once())
            ->method('getTasks')
            ->with(date('Y-m-d'))
            ->willReturn([]);

        $this->assertSame([], $this->service->getTodayTasks());
    }

    public function testGetTodayUndoneTasks()
    {
        $this->repository->expects($this->once())
            ->method('getTasks')
            ->with(date('Y-m-d'), false)
            ->willReturn([]);

        $this->assertSame([], $this->service->getTodayUndoneTasks());
    }

    public function testGetTodayDoneTasks()
    {
        $this->repository->expects($this->once())
            ->method('getTasks')
            ->with(date('Y-m-d'), true)
            ->willReturn([]);

        $this->assertSame([], $this->service->getTodayDoneTasks());
    }

    public function testDoneTask()
    {
        $taskId = 1;
        $task = new Task();
        $this->repository->expects($this->once())
            ->method('find')
            ->willReturn($task);

        $this->repository->expects($this->once())
            ->method('saveTask')
            ->with($task, ['done' => true])
            ->willReturn($task);

        $this->assertSame($task, $this->service->doneTask($taskId));
    }

    public function testDoneTaskNotFound()
    {
        $taskId = 1;
        $this->repository->expects($this->once())
            ->method('find')
            ->willReturn(null);

        $this->expectException(NotFoundHttpException::class);
        $this->service->doneTask($taskId);
    }

    public function testUndsoneTask()
    {
        $taskId = 1;
        $task = new Task();
        $this->repository->expects($this->once())
            ->method('find')
            ->willReturn($task);

        $this->repository->expects($this->once())
            ->method('saveTask')
            ->with($task, ['done' => false])
            ->willReturn($task);

        $this->assertSame($task, $this->service->undoneTask($taskId));
    }

    public function testUndoneTaskNotFound()
    {
        $taskId = 1;
        $this->repository->expects($this->once())
            ->method('find')
            ->willReturn(null);

        $this->expectException(NotFoundHttpException::class);
        $this->service->undoneTask($taskId);
    }

    protected function setUp(): void
    {
        $this->repository = $this->createMock(TaskRepository::class);
        $this->service = new TaskService($this->repository);
    }
}
