<?php

declare(strict_types=1);

use App\Helpers\App;
use App\Helpers\Container\Container;
use App\Helpers\Database\Database;
use App\Helpers\Exceptions\ExceptionHandler;
use App\Helpers\Router\Router;

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

$router->addRoute('get', '/products', 'Domain\Product\Http\ProductController@index');
$router->addRoute('get', '/products/(\d+)', 'Domain\Product\Http\ProductController@show');
$router->addRoute('post', '/products', 'Domain\Product\Http\ProductController@store');
$router->addRoute('delete', '/products/(\d+)', 'Domain\Product\Http\ProductController@delete');
$router->addRoute('delete', '/products/bulk-delete', 'Domain\Product\Http\ProductController@bulkDelete');

$response = $router->serveRoute($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

$response->send();
