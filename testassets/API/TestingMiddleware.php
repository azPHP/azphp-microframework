<?php


namespace AZMicroAssets\API;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TestingMiddleware implements MiddlewareInterface
{
    /**
     * @var ServerRequestInterface
     */
    public ?ServerRequestInterface $request;
    /**
     * @var ResponseInterface
     */
    public ResponseInterface $response;

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $this->request = $request;
        $this->response = $handler->handle($request);
        return $this->response;
    }
}
