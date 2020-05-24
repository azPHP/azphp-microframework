<?php


namespace AZMicro\Bootstrap;

use Auryn\Injector;
use FastRoute\Dispatcher;
use FastRoute\RouteParser;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Psr\Http\Message\ServerRequestInterface;
use Relay\Relay;
use Relay\RelayBuilder;

use function FastRoute\simpleDispatcher;

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
        $dispatcher = static function () use ($routes) { return simpleDispatcher($routes); };
        $di->delegate(Dispatcher::class, $dispatcher);
        $di->alias(RouteParser::class, RouteParser\Std::class);
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
