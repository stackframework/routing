<?php
/**
 * This file is part of the Stack package.
 *
 * (c) Andrzej Kostrzewa <andkos11@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Stack\Routing;

/**
 * Collection of Route.
 *
 * @author Andrzej Kostrzewa <andkos11@gmail.com>
 */
class RouteCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var array
     */
    private $routes = [];

    /**
     *  Clone of the RouteCollection.
     */
    public function __clone()
    {
        foreach ($this->routes as $name => $route) {
            $this->routes[$name] = clone $route;
        }
    }

    /**
     * Add route to collection.
     *
     * @param Route $route
     */
    public function add(Route $route)
    {
        $name = $route->name();

        unset($this->routes[$name]);

        $this->routes[$name] = $route;
    }

    /**
     * Add collection of route.
     *
     * @param RouteCollection $collection
     */
    public function addCollection(RouteCollection $collection)
    {
        foreach ($collection as $name => $route) {
            unset($this->routes[$name]);

            $this->routes[$name] = $route;
        }
    }

    /**
     * Count route in collection.
     *
     * @return int
     */
    public function count() : int
    {
        return count($this->routes);
    }

    /**
     * Get route from collection.
     *
     * @param string $name
     *
     * @return Route
     * @throws Exception\RouteNotFound
     */
    public function get(string $name) : Route
    {
        if (!isset($this->routes[$name])) {
            throw Exception::RouteNotFound($name);
        }

        return $this->routes[$name];
    }

    /**
     * Get iterator of collection.
     *
     * @return \ArrayIterator
     */
    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator($this->routes);
    }
}
