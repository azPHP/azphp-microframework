<?php


namespace AZMicroAssets\Bootstrap;


use AZMicro\Bootstrap\AbstractBootstrap;

class UnitBootstrap extends AbstractBootstrap
{
    public function prepare(array $diConfigurators = [], array $middlewares = []): void
    {
        array_unshift($diConfigurators, require dirname(__DIR__).'/files/diconfig.php');
        array_unshift($middlewares, require dirname(__DIR__).'/files/middlewares.php');
        parent::prepare($diConfigurators, $middlewares);
    }
}
