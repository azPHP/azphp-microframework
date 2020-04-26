<?php

use Auryn\Injector;
use Psr\Log\LoggerInterface;
use Psr\Log\Test\TestLogger;

return static function(Injector $container)
{
    $container
        ->alias(LoggerInterface::class, TestLogger::class)
        ->share(LoggerInterface::class)
    ;

};
