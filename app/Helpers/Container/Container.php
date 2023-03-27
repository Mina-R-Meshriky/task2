<?php

/**
 * credits to https://dev.to/azibom/make-your-own-service-container-php-51oe
 */

namespace App\Helpers\Container;


use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;

class Container implements ContainerInterface
{

    private array $services = [];

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws ReflectionException
     * @throws NotFoundException
     */
    public function get($id)
    {
        $item = $this->resolve($id);
        if (!($item instanceof ReflectionClass)) {
            return $item;
        }
        return $this->getInstance($item);
    }

    /**
     * @param $id
     * @return bool
     */
    public function has($id): bool
    {
        try {
            $item = $this->resolve($id);
        } catch (NotFoundException $e) {
            return false;
        }
        if ($item instanceof ReflectionClass) {
            return $item->isInstantiable();
        }
        return isset($item);
    }

    /**
     * @param  string  $key
     * @param $value
     * @return $this
     */
    public function set(string $key, $value): self
    {
        $this->services[$key] = $value;
        return $this;
    }

    /**
     * @throws NotFoundException
     */
    private function resolve($id)
    {
        try {
            $name = $id;
            if (isset($this->services[$id])) {
                $name = $this->services[$id];
                if (is_callable($name)) {
                    return $name();
                }
            }
            return (new ReflectionClass($name));
        } catch (ReflectionException $e) {
            throw new NotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param  ReflectionClass  $item
     * @return object|null
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    private function getInstance(ReflectionClass $item): ?object
    {
        $constructor = $item->getConstructor();
        if (is_null($constructor) || $constructor->getNumberOfRequiredParameters() == 0) {
            return $item->newInstance();
        }
        $params = [];
        foreach ($constructor->getParameters() as $param) {
            if ($type = $param->getType()) {
                $params[] = $this->get($type->getName());
            }
        }
        return $item->newInstanceArgs($params);
    }

}