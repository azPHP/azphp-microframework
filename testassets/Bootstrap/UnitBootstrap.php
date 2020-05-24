<?php


namespace AZMicroAssets\Bootstrap;


use AZMicro\Bootstrap\AbstractBootstrap;

class UnitBootstrap extends AbstractBootstrap
{
    public function prepare(?array $diConfigurators = [], ?array $middlewares = [], ?callable $routes = null): void
    {
        array_unshift($diConfigurators, require dirname(__DIR__).'/files/diconfig.php');
        array_unshift($middlewares, ...require dirname(__DIR__).'/files/middlewares.php');
        parent::prepare(
            $diConfigurators,
            $middlewares,
            require dirname(__DIR__).'/files/routes.php'
        );
    }
}
