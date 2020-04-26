<?php

namespace AZMicroTest\Bootstrap;

use AZMicroAssets\Bootstrap\LoggerService;
use AZMicroAssets\Bootstrap\UnitBootstrap;
use PHPUnit\Framework\TestCase;

class AbstractBootstrapTest extends TestCase
{

    public function testBootstrapReturnsContainer(): void
    {
        $this->doesNotPerformAssertions();
        $bs = new UnitBootstrap();

        $bs->prepare([]);
        $bs->bootstrap();
    }

    public function testContainerIsConfiguredForLogger(): void
    {
        $bs = new UnitBootstrap();

        $bs->prepare([]);
        $di = $bs->bootstrap();

        $logger = $di->make(LoggerService::class);

        $this->assertInstanceOf(LoggerService::class, $logger);
    }
}
