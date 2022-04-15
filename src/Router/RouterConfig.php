<?php

namespace Steodec\Router\Router;

use Exception;
use ReflectionClass;
use ReflectionException;
use HaydenPierce\ClassFinder\ClassFinder;

class RouterConfig
{
    /**
     * @var string
     */
    private string $namespace;

    /**
     * @var callable|null
     */
    private mixed $middleware;

    public function __construct(string $namespace, ?callable $middleware = NULL)
    {
        $this->namespace = $namespace;
        $this->middleware = $middleware;
    }

    /**
     * @throws RouterException
     * @throws ReflectionException
     * @throws Exception
     */
    public function run()
    {
        $classes = ClassFinder::getClassesInNamespace($this->getNamespace(), ClassFinder::RECURSIVE_MODE);
        $routes = [];
        foreach ($classes as $class) {
            $routes = array_merge($routes, self::registerController($class));
        }
        $router = new Router($_GET['url']);
        foreach ($routes as $route) {
            if (empty($route->getIsGranted())):
                $router->add($route->getPath(), $route->getCallable(), $route->getName(), $route->getMethod());
            else:
                if ($this->getMiddleware() == NULL or $this->getMiddleware()($route)) {
                    $router->add($route->getPath(), $route->getCallable(), $route->getName(), $route->getMethod());
                }
            endif;
        }
        $router->run();
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     */
    public function setNamespace(string $namespace): void
    {
        $this->namespace = $namespace;
    }

    /**
     * @throws ReflectionException
     */
    public function registerController(string $controller): array
    {
        $class = new ReflectionClass($controller);
        $routeArray = [];
        foreach ($class->getMethods() as $method) {
            $router = $method->getAttributes(\Steodec\Attributes\Route::class);
            if (empty($router)) continue;
            foreach ($router as $r) {
                $newRoute = $r->newInstance();
                if (empty($newRoute->getPath())) $newRoute->setPath("/" . $method->name);
                if (empty($newRoute->getMethod())) $newRoute->setMethod("GET");
                $newRoute->setCallable($method->class . "#" . $method->name);
                $routeArray[] = $newRoute;
            }
        }
        return $routeArray;
    }

    /**
     * @return callable|null
     */
    public function getMiddleware(): ?callable
    {
        return $this->middleware;
    }

    /**
     * @param callable|null $middleware
     */
    public function setMiddleware(mixed $middleware): void
    {
        $this->middleware = $middleware;
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     * @return array
     */
    public function getRoute(): array
    {
        $classes = ClassFinder::getClassesInNamespace($this->getNamespace(), ClassFinder::RECURSIVE_MODE);
        $routes = [];
        foreach ($classes as $class) {
            $routes = array_merge($routes, self::registerController($class));
        }
        return $routes;
    }
}
