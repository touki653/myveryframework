<?php

require __DIR__.'/../vendor/autoload.php';

use Touki\MVF\Router\Route;
use Touki\MVF\Router\Router;
use Touki\MVF\Router\RouteCollection;
use Touki\MVF\Router\ControllerReference;
use Touki\MVF\Router\LazyControllerReference;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FakeController
{
    protected $bar;

    public function __construct(Bar $bar)
    {
        $this->bar = $bar;
    }

    public function indexAction(Request $request)
    {
        return new Response("Hello world");
    }
}

class LazyController
{
    protected $baz;

    public function __construct(Baz $baz)
    {
        $this->baz = $baz;
    }

    public function indexAction(Request $request)
    {
        return new Response("Hello lazy world");
    }
}

class Bar {}
class Baz {}

$bar = new Bar;

$firstController = new ControllerReference;
$firstController->setController(array(new FakeController($bar), 'indexAction'));

$secondController = new ControllerReference;
$secondController->setController((function (Request $request) {
    return new Response("Blahblahbklah");
}));

$thirdController = new LazyControllerReference;
$thirdController->setController('LazyController', 'indexAction');
$thirdController->setArgumentsProvider(function () {
    return array(new Baz);
});

$collection = new RouteCollection;
$collection->add(new Route("index", function (Request $request) {
    return '/' === $request->getPathInfo();
}, $firstController));

$router = new Router;
$router->addCollection($collection);

$request = Request::createFromGlobals();

$route = $router->match($request);

$controller = $route->getReference()->getController();

$response = call_user_func_array($controller, array($request));
$response->send();
