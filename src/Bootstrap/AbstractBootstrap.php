<?php


namespace AZMicro\Bootstrap;

use Auryn\Injector;
use FastRoute\Dispatcher;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Psr\Http\Message\ServerRequestInterface;
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
    public function prepare(array $diConfigurators, array $middlewares, callable $routes): void
    {
        $this->prepareMiddleware($middlewares);
        foreach ($diConfigurators as $config) {
            $config(self::$container);
        }
        if (!empty($this->middlewares)) {
            $this->prepareDispatcher($routes);
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

    protected function prepareDispatcher(callable $routes): void
    {
        $di = self::$container;

        array_push($this->middlewares, FastRoute::class, RequestHandler::class);
        // prepare the router
        $di->delegate(Dispatcher::class, $routes);
    }

    public function dispatch(ServerRequestInterface $request): void
    {
        $di = self::$container;
        $this->dispatcher = (new RelayBuilder(static function (string $class) use ($di) {
            return $di->make($class);
        }))
            ->newInstance($this->middlewares);
        $this->dispatcher->handle($request);
    }
}
