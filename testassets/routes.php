<?php

use AZMicroAssets\API;
use FastRoute\RouteCollector;

return static function (RouteCollector $routes) {
    $routes->get('/test', API\TestAction::class);
    $routes->get('/error', API\ErrorAction::class);
};
