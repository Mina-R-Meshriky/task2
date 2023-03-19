<?php

use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{

    public function test_throw_an_exception_if_no_routes_are_defined()
    {
        $router = new \App\Helpers\Router\Router();

        $this->expectExceptionCode(500);

        $router->serveRoute('/unknown', 'GET');
    }

    public function test_router_should_have_method_to_add_routes()
    {
        $router = new \App\Helpers\Router\Router();

        $router->addRoute('get', '/', 'Domain\Something\SomeController@index');

        $routes = $router->getRoutes();

        $this->assertTrue(count($routes) === 1);
    }

    public function test_routes_has_path_method_controller_handler()
    {
        $router = new \App\Helpers\Router\Router();

        $router->addRoute('get', '/', 'Domain\Something\SomeController@index');

        $route = $router->getRoutes()['get/'];

        $this->assertEquals('GET', $route->getMethod());
        $this->assertEquals('\App\Domain\Something\SomeController', $route->getController());
        $this->assertEquals('', $route->getPath());
        $this->assertEquals('index', $route->getHandler());
    }

    public function test_2_paths_can_exist_but_with_different_methods()
    {
        $router = new \App\Helpers\Router\Router();

        $router->addRoute('get', '/', 'Domain\Something\SomeController@index');
        $router->addRoute('post', '/', 'Domain\Something\SomeController@index');

        $this->assertTrue(count($router->getRoutes()) === 2);
    }

    public function test_if_route_does_not_exist_it_will_return_not_found_response()
    {
        $router = new \App\Helpers\Router\Router();
        $router->addRoute('get', '/', 'Domain\Something\SomeController@index');

        $response = $router->serveRoute('/unknown', 'GET');

        $this->assertEquals(404, $response->getCode());
    }


}