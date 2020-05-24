<?php


namespace AZMicroTest\API;


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

    public function testDispatchTestRoute()
    {
        /** @var ServerRequestInterface|ServerRequest $request */
        $request = ServerRequestFactory::fromGlobals()
            ->withMethod('GET')
            ->withUri(new Uri('/path'));
        $this->bs->dispatch($request);
    }
}
