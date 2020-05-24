<?php


namespace AZMicroTest\API;


use AZMicroAssets\API\TestAction;
use AZMicroAssets\API\TestingMiddleware;
use AZMicroAssets\Bootstrap\UnitBootstrap;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class DispatcherTest extends TestCase
{
    protected UnitBootstrap $bs;

    public function setUp(): void
    {
        parent::setUp();
        $this->bs = new UnitBootstrap();
        $this->bs->prepare();
        $this->bs->bootstrap();
    }

    public function testDispatchTestRoute(): void
    {
        /** @var ServerRequestInterface|ServerRequest $request */
        $request = ServerRequestFactory::fromGlobals()
            ->withMethod('GET')
            ->withUri(new Uri('/test'));
        $this->bs->dispatch($request);
        $testMiddleware = $this->bs->getContainer()->make(TestingMiddleware::class);

        $response = $testMiddleware->response;
        $response->getBody()->rewind();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(TestAction::TEST_OUTPUT, $response->getBody()->getContents());
    }

    public function testDispatchErrorRoute(): void
    {
        /** @var ServerRequestInterface|ServerRequest $request */
        $request = ServerRequestFactory::fromGlobals()
            ->withMethod('GET')
            ->withUri(new Uri('/error'));
        $this->bs->dispatch($request);
        $testMiddleware = $this->bs->getContainer()->make(TestingMiddleware::class);

        $response = $testMiddleware->response;
        $response->getBody()->rewind();
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertStringContainsString('Something bad happened', $response->getBody()->getContents());
    }

    public function testDispatchErrorRouteRequiringJson(): void
    {
        /** @var ServerRequestInterface|ServerRequest $request */
        $request = ServerRequestFactory::fromGlobals()
            ->withMethod('GET')
            ->withHeader('Accept', 'application/json')
            ->withUri(new Uri('/error'));
        $this->bs->dispatch($request);
        $testMiddleware = $this->bs->getContainer()->make(TestingMiddleware::class);

        $response = $testMiddleware->response;
        $response->getBody()->rewind();
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('{"type":"RuntimeException","code":0,"message":"Something bad happened"}', $response->getBody()->getContents());
        $this->assertContainsEquals('application/json', $response->getHeader('Content-Type'));
    }
}
