<?php

namespace App\Tests\Unit\Controller;

use App\Controller\TaskController;
use App\Service\TaskService;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @covers \App\Controller\TaskController
 */
class TaskControllerTest extends KernelTestCase
{
    protected TaskController $taskController;

    protected MockObject|SerializerInterface $serializer;

    protected MockObject|TaskService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->createMock(TaskService::class);
        $this->serializer = $this->createMock(SerializerInterface::class);
        $this->taskController = new TaskController($this->service, $this->serializer);
    }

    public function testDummy()
    {
        $this->assertSame(1, 1);
    }
}
