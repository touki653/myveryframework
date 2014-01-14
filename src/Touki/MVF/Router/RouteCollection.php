<?php

namespace Touki\MVF\Router;

/**
 * Route collection holds routes! WOW
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class RouteCollection
{
    protected $routes = array();

    /**
     * Constructor
     *
     * @param array $routes An array of routes
     */
    public function __construct(array $routes = array())
    {
        $this->routes = $routes;
    }

    /**
     * Adds a collection with a collection
     *
     * @param RouteCollection $routes A Collection
     */
    public function addCollection(RouteCollection $routes)
    {
        $this->routes = array_merge($routes->getRoutes(), $this->routes);
    }

    /**
     * Adds a route
     *
     * @param Route $route Route to add
     */
    public function add(Route $route)
    {
        $this->routes[$route->getName()] = $route;
    }

    /**
     * Get routes
     *
     * @return array Routes
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}
