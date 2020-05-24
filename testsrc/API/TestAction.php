<?php


namespace AZMicroAssets\API;


use Middlewares\Utils\Factory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TestAction implements RequestHandlerInterface
{
    public const TEST_OUTPUT = 'Test completed';
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = Factory::createResponse();
        $response->getBody()->write(self::TEST_OUTPUT);
        return $response;
    }
}
