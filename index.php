<?php

declare(strict_types=1);

use App\Helpers\App;
use App\Helpers\Container\Container;
use App\Helpers\Database\Database;

require __DIR__.'/vendor/autoload.php';

$config = require 'config.php';

App::setContainer(new Container());

App::bind(Database::class, function() use ($config) {
    return Database::getInstance($config['database']);
});

$router = new \App\Helpers\Router\Router();

$router->addRoute('get', '/products', 'Domain\Product\ProductController@index');
$router->addRoute('get', '/products/{product}', 'Domain\Product\ProductController@show');
$router->addRoute('post', '/products', 'Domain\Product\ProductController@store');
$router->addRoute('delete', '/products/{product}', 'Domain\Product\ProductController@delete');

$response = $router->serveRoute($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

$response->send();
