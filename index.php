<?php

declare(strict_types=1);

require __DIR__.'/vendor/autoload.php';

$config = require 'config.php';

\App\Helpers\Database\Database::getInstance($config['database']);

$router = new \App\Helpers\Router\Router();

$router->addRoute('get', '/products', 'Domain\Product\ProductController@index');
$router->addRoute('get', '/products/{product}', 'Domain\Product\ProductController@show');
$router->addRoute('post', '/products', 'Domain\Product\ProductController@store');
$router->addRoute('delete', '/products/{product}', 'Domain\Product\ProductController@delete');

$response = $router->serveRoute($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

$response->send();
