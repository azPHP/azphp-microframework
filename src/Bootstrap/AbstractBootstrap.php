<?php


namespace AZMicro\Bootstrap;

use Auryn\Injector;
use Relay\Relay;
use Relay\RelayBuilder;

abstract class AbstractBootstrap
{
    /**
     * @var Injector
     */
    protected static Injector $container;
    protected array $middlewares = [];
    protected Relay $dispatcher;

    public function __construct()
    {
        self::$container = new Injector();
    }

    /**
     * @param callable[] $diConfigurators
     * @param string[] $middlewares
     */
    public function prepare(array $diConfigurators, array $middlewares): void
    {
        $this->prepareMiddleware($middlewares);
        foreach ($diConfigurators as $config) {
            $config(self::$container);
        }
        if (!empty($this->middlewares)) {
            $this->prepareDispatcher();
        }
    }

    protected function prepareMiddleware(array $middlewares = []): void
    {
        $this->middlewares = $middlewares;
    }

    public function bootstrap(): Injector
    {
        return self::$container;
    }

    protected function prepareDispatcher(): void
    {
        $di = self::$container;
        $this->dispatcher = (new RelayBuilder(static function (string $class) use ($di) {
            return $di->make($class);
        }))
            ->newInstance($this->middlewares);
    }
}
