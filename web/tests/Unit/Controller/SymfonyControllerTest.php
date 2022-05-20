<?php

namespace App\Tests\Unit\Controller;

use App\Controller\SymfonyController;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class SymfonyControllerTest extends KernelTestCase
{
    private SymfonyController $controller;

    private MockObject $request;

    private MockObject $query;

    private ?string $originalEnv;

    public function testSuccess(): void
    {
        putenv('APP_ENV=dev');

        $this->query->method('get')->with('phpinfo')->willReturn(null);
        $this->request->expects($this->once())->method('getUri')->willReturn('http://localhost/server_info');

        $response = $this->controller->info($this->request);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
    }

    public function testForbidden(): void
    {
        putenv('APP_ENV=prod');

        $this->query->expects($this->never())->method('get');
        $this->request->expects($this->never())->method('getUri');

        $this->expectException(UnauthorizedHttpException::class);

        $response = $this->controller->info($this->request);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->originalEnv = getenv('APP_ENV');
        $this->controller = new SymfonyController();
        $this->request = $this->createMock(Request::class);
        $this->query = $this->createMock(ParameterBag::class);
        $this->request->query = $this->query;
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        putenv('APP_ENV='.$this->originalEnv);
    }
}
