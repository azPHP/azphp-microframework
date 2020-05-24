<?php


namespace AZMicroAssets\Bootstrap;


use Auryn\Injector;
use AZMicro\Bootstrap\AbstractBootstrap;

class UnitBootstrap extends AbstractBootstrap
{
    public function prepare(?array $diConfigurators = [], ?array $middlewares = [], ?callable $routes = null): void
    {
        array_unshift($diConfigurators, require dirname(__DIR__, 2).'/testassets/diconfig.php');
        array_unshift($middlewares, ...require dirname(__DIR__, 2).'/testassets/middlewares.php');
        parent::prepare(
            $diConfigurators,
            $middlewares,
            require dirname(__DIR__, 2).'/testassets/routes.php'
        );
    }

    public function getContainer(): Injector
    {
        return self::$container;
    }
}
