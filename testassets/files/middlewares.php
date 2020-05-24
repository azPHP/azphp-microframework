<?php

use AZMicroAssets\API\TestingMiddleware;
use Middlewares\ErrorHandler;

return [
    TestingMiddleware::class,
    ErrorHandler::class,
];
