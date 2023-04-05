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

        if ($route = $this->getRoute($method, $path, $pathParts)) {
            return $route->handle($pathParts);
        }

        return (new Response())->changeCode(Response::NOTFOUND);
    }


    public function getRoute(string $method, string $path, &$matches): ?Route
    {
        foreach ($this->getRoutes() as $r) {
            if (preg_match('/^'.$r->getIdentifier().'$/', $method.$path, $matches)) {
                array_shift($matches);
                return $r;
            }
        }

        return null;
    }
}
