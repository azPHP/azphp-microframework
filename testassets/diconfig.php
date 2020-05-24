<?php

use Auryn\Injector;
use AZMicroAssets\API\TestingMiddleware;
use Psr\Log\LoggerInterface;
use Psr\Log\Test\TestLogger;

return static function(Injector $container)
{
    $container
        ->alias(LoggerInterface::class, TestLogger::class)
        ->share(LoggerInterface::class)
        ->share(TestingMiddleware::class)
    ;

};
