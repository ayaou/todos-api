<?php

namespace Unit\Controller\Task;

use App\Entity\Task;
use App\Tests\Unit\Controller\TaskControllerTest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @covers \App\Controller\TaskController
 */
class DoneUndoneTaskTest extends TaskControllerTest
{
    public function testdoneTask()
    {
        $task = new Task();
        $taskId = 1;
        $json = '{"id": 1, "done": true}';

        $this->service->expects($this->once())
            ->method('doneTask')
            ->with($taskId)
            ->willReturn($task);

        $this->serializer->expects($this->once())
            ->method('serialize')
            ->with($task, 'json')
            ->willReturn($json);

        $response = $this->taskController->doneTask($taskId);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame($json, $response->getContent());
    }

    public function testdoneTaskUnfound()
    {
        $taskId = 1;

        $this->service->expects($this->once())
            ->method('doneTask')
            ->willThrowException(new NotFoundHttpException('No task found with the id '.$taskId));

        $this->expectException(NotFoundHttpException::class);

        $this->taskController->doneTask($taskId);
    }

    public function testUndoneTask()
    {
        $task = new Task();
        $taskId = 1;
        $json = '{"id": 1, "done": false}';

        $this->service->expects($this->once())
            ->method('undoneTask')
            ->with($taskId)
            ->willReturn($task);

        $this->serializer->expects($this->once())
            ->method('serialize')
            ->with($task, 'json')
            ->willReturn($json);

        $response = $this->taskController->undoneTask($taskId);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame($json, $response->getContent());
    }

    public function testUndoneTaskUnfound()
    {
        $taskId = 1;

        $this->service->expects($this->once())
            ->method('undoneTask')
            ->willThrowException(new NotFoundHttpException('No task found with the id '.$taskId));

        $this->expectException(NotFoundHttpException::class);

        $this->taskController->undoneTask($taskId);
    }
}
