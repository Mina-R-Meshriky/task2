<?php

namespace App\Core;

use App\Core\Container\Container;

class App
{
    protected static Container $container;

    public static function setContainer($container)
    {
        static::$container = $container;
    }

    public static function container(): Container
    {
        return static::$container;
    }

    public static function bind($key, $implementation)
    {
        static::$container->set($key, $implementation);
    }

    public static function resolve($key)
    {
        return static::$container->get($key);
    }

}