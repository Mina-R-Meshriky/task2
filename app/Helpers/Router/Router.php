<?php

declare(strict_types=1);

namespace App\Helpers\Router;

use App\Helpers\Response\Response;

class Router
{
    /** @var array<Route> */
    private array $routes = [];

    /**
     * @throws \Exception
     */
    public function addRoute(string $method, string $path, string $controllerHandler): void
    {
        $this->routes[$method.$path] = new Route($path, $method, $controllerHandler);
    }

    /**
     * @return array<Route>
     */
    public function getRoutes(): array
    {
        ksort($this->routes);
        return $this->routes;
    }

    /**
     * @throws \Exception
     */
    public function serveRoute(string $requestUri, string $method): Response
    {
        if(count($this->routes) == 0) {
            throw new \Exception("there are no defined routes to serve", 500);
        }

        $path = trim(parse_url($requestUri)['path'], '\/');

        $pathParts = explode('/', $path);

        if ($route = $this->getRoute($method, $pathParts)) {
            return $route->handle($pathParts);
        }

        return (new Response())->changeCode(Response::NOTFOUND);
    }


    public function getRoute(string $method, array $pathParts): ?Route
    {
        $base = $pathParts[0];
        $argsCount = count($pathParts) - 1;

        foreach ($this->getRoutes() as $r) {
            if ($method.$base.$argsCount == $r->getMethod().$r->getBase().count($r->getArgs())) {
                return $r;
            }
        }

        return null;
    }
}
