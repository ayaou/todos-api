<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Kernel as KernelAlias;

class SymfonyController extends AbstractController
{
    public function info(Request $request): JsonResponse
    {
        if (!in_array(getenv('APP_ENV'), ['dev', 'test'])) {
            throw new UnauthorizedHttpException('private-content');
        }

        if ('1' === $request->query->get('phpinfo')) {
            phpinfo();
            exit(0);
        }

        $data = [
            'poweredBy' => [
                'Symfony ' => KernelAlias::VERSION,
                'PHP ' => PHP_VERSION,
            ],
            'projectDir' => dirname(__DIR__, 2),
            'phpinfo' => $this->getPhpInfoUri($request->getUri()),
        ];

        return new JsonResponse($data);
    }

    private function getPhpInfoUri($uri): string
    {
        $p = parse_url($uri);
        extract($p);
        return $scheme . '://' . $host . ($port === 80 ? '' : (':' . $port)) . $path . '?phpinfo=1';
    }
}
