<?php

use AZMicroAssets\API\TestAction;
use FastRoute\RouteCollector;

return static function (RouteCollector $routes) {
    $routes->get('/test', TestAction::class);
};
