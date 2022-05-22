<?php

namespace App\Tests\Unit\Controller\Task;

use App\Entity\Task;
use App\Tests\Unit\Controller\TaskControllerTest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \App\Controller\TaskController
 */
class TodayTest extends TaskControllerTest
{
    public function testTodayNoTasks()
    {
        $data = [];
        $dataSerialized = '[]';

        $this->service->expects($this->once())
            ->method('getTodayTasks')->willReturn($data);

        $this->serializer->expects($this->once())
            ->method('serialize')->with($data, 'json')->willReturn($dataSerialized);

        $response = $this->taskController->today();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame($dataSerialized, $response->getContent());
    }

    public function testTodayUndoneNoTasks()
    {
        $data = [];
        $dataSerialized = '[]';

        $this->service->expects($this->once())
            ->method('getTodayUndoneTasks')->willReturn($data);

        $this->serializer->expects($this->once())
            ->method('serialize')->with($data, 'json')->willReturn($dataSerialized);

        $response = $this->taskController->todayUndone();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame($dataSerialized, $response->getContent());
    }

    public function testTodayDoneNoTasks()
    {
        $data = [];
        $dataSerialized = '[]';

        $this->service->expects($this->once())
            ->method('getTodayDoneTasks')->willReturn($data);

        $this->serializer->expects($this->once())
            ->method('serialize')->with($data, 'json')->willReturn($dataSerialized);

        $response = $this->taskController->todayDone();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame($dataSerialized, $response->getContent());
    }

    public function testTadayTasks()
    {
        $today = new \DateTime();
        $data = [
            (new Task())->setTitle('A')->setDescription('AA')->setDay($today)->setDone(false),
            (new Task())->setTitle('B')->setDescription('BB')->setDay($today)->setDone(true),
            (new Task())->setTitle('C')->setDescription('CC')->setDay($today)->setDone(false),
        ];

        $dataSerialized = '[
        {"id": 1, "title":"A", "description":"AA", "day":"' . $today->format('Y-m-d') . '", "done":false},
        {"id": 2, "title":"B", "description":"BB", "day":"' . $today->format('Y-m-d')  . '", "done":true},
        {"id": 3, "title":"C", "description":"CC", "day":"' . $today->format('Y-m-d')  . '", "done":false}
        ]';

        $this->service->expects($this->once())
            ->method('getTodayTasks')->willReturn($data);

        $this->serializer->expects($this->once())
            ->method('serialize')->with($data, 'json')->willReturn($dataSerialized);

        $response = $this->taskController->today();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame($dataSerialized, $response->getContent());
    }
}
