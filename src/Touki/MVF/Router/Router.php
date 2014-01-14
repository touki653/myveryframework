<?php

namespace Touki\MVF\Router;

use Symfony\Component\HttpFoundation\Request;

/**
 * Router Routes Routes - Routeception
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class Router
{
    /**
     * Route Collection
     * @var RouteCollection
     */
    protected $collection;

    public function __construct(RouteCollection $collection = null)
    {
        $this->collection = $collection ?: new RouteCollection;
    }

    /**
     * Adds a collection
     *
     * @param RouteCollection $coll Route Collection
     */
    public function addCollection(RouteCollection $coll)
    {
        $this->collection->addCollection($coll);
    }

    /**
     * Matches the request
     *
     * @param Request $request Request to match on
     *
     * @return Route
     */
    public function match(Request $request)
    {
        foreach ($this->collection->getRoutes() as $route) {
            if (true === $route->match($request)) {
                return $route;
            }
        }
    }
}
