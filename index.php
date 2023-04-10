<?php

declare(strict_types=1);

use App\Core\App;
use App\Core\Container\Container;
use App\Core\Database\Database;
use App\Core\Exceptions\ExceptionHandler;
use App\Core\Router\Router;

require __DIR__.'/vendor/autoload.php';

set_exception_handler(function ($e) {
    if($e instanceof Exception) {
        ExceptionHandler::handle($e);
    }

    throw $e;
});

$config = require 'config.php';

App::setContainer(new Container());

App::bind(Database::class, function() use ($config) {
    return Database::getInstance($config['database']);
});



$router = new Router();
$router->addRoute('get', '/', 'Domain\Product\Http\ProductController@index');
$router->addRoute('get', '/products', 'Domain\Product\Http\ProductController@index');
$router->addRoute('get', '/products/create', 'Domain\Product\Http\ProductController@create');

$router->addRoute('get', '/api/products', 'Domain\Product\Http\ProductApiController@index');
$router->addRoute('get', '/api/products/(\d+)', 'Domain\Product\Http\ProductApiController@show');
$router->addRoute('post', '/api/products', 'Domain\Product\Http\ProductApiController@store');
$router->addRoute('delete', '/api/products/(\d+)', 'Domain\Product\Http\ProductApiController@delete');
$router->addRoute('post', '/api/products/bulk-delete', 'Domain\Product\Http\ProductApiController@bulkDelete');

$router->addRoute('get', '/api/product-types', 'Domain\ProductType\Http\ProductTypeApiController@index');

$response = $router->serveRoute($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

$response->send();
