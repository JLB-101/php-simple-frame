<?php

namespace piecing\routing;

use Throwable;

class Router
{
    protected array $routes = [];
    protected array $errorHandler = [];

    public function add(string $method, string $path, callable $handler): Route
    {
        $route = $this->routes[] = new Route($method, $path, $handler);
        return $route;
    }

    // dispatch method
    public function dispatch()
    {
        $paths = $this->paths();

        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $requestPath = $_SERVER['REQUEST_URI'] ?? '/';

        // this looks through the defined routes and returns
        //the frist that matches the requested method and path

        $matching = $this->match($requestMethod, $requestPath);
        if ($matching) {
            try {
                //this action could throw and exception
                // so we catch it and display the global error
                // page that we will define in the routes file
                return $matching->dispatch();
            } catch (Throwable $e) {
                return $this->dispatchError();
            }
        }
        if (in_array($requestPath, $paths)) {
            return $this->dispatchNotAllowed();
        }

        return $this->dispatchNotFound();
    }

    // paths
    private function paths(): array
    {
        $paths = [];
        foreach ($this->routes as $route) {
            $paths[] = $route->path();
        }
        return $paths;
    }

    // match
    private function match(string $method, string $path): ?Route
    {
        foreach ($this->routes as $route) {
            if ($route->matches($method, $path)) {
                return $route;
            }
        }
        return null;
    }

  
    // errorHandler
    public function errorHandler(int $code, callable $handler)
    {
        $this->errorHandler[$code] = $handler;
    }

    // dispatchNotAllowed
    public function dispatchNotAllowed()
    {
        $this->errorHandler[400] ??= fn() => "not allowed";
        return $this->errorHandler[400]();    
    }

    // dispatchNotFound
    public function dispatchNotFound()
    {
        $this->errorHandler[404] ??= fn() => "not found";
        return $this->errorHandler[404]();
    }

    // dispatchError
    public function dispatchError()
    {
        $this->errorHandler[500] ??= fn() => "server error";
        return $this->errorHandler[500]();    
    }

    // redirect
    public function redirect($path)
    {
        header("Location: {$path}", $replace = true, $code = 301);
        exit;    
    }
}
