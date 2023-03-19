<?php

declare(strict_types=1);

namespace App\Helpers\Router;

use App\Helpers\Response\Response;

final class Route
{
    private string $path;
    private string $method;
    private string $controller;
    private string $handler;

    /**
     * @throws \Exception
     */
    public function __construct(
        string $path,
        string $method,
        string $controllerHandler
    ) {
        $this->addPath($path);
        $this->addMethod($method);
        $this->addControllerAndHandler($controllerHandler);
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getController(): string
    {
        return '\App\\'.$this->controller;
    }

    public function getHandler(): string
    {
        return $this->handler;
    }

    public function getBase(): string
    {
        return explode('/', $this->getPath())[0];
    }

    public function getArgs(): array
    {
        $paths = explode('/', $this->getPath());
        array_shift($paths);
        return $paths;
    }

    public function handle(array $pathParts): Response
    {
        array_shift($pathParts);

        $c = $this->getController();
        $c = new $c();
        return $c->{$this->getHandler()}(...$pathParts);
    }

    /**
     * @throws \Exception
     */
    private function addMethod(string $method): void
    {
        $method = strtoupper(trim($method));

        if (! in_array($method, ['GET', 'POST', 'DELETE', 'PATCH'])) {
            throw new \Exception("route methods must be one of 'get', 'post', 'delete', 'patch'", 500);
        }

        $this->method = $method;
    }

    private function addPath(string $path): void
    {
        $this->path = trim($path, " \t\n\r\0\x0B\/");
    }

    private function addControllerAndHandler(string $controllerHandler): void
    {
        [$this->controller, $this->handler] =
            array_map(
                static fn($i) => trim($i),
                explode('@', $controllerHandler)
            );
    }
}
