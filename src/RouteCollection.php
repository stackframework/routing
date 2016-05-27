<?php
/**
 * This file is part of the Stack package.
 *
 * (c) Andrzej Kostrzewa <andkos11@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Stack\Routing;

class RouteCollection implements \IteratorAggregate, \Countable
{
    private $routes = [];

    public function __clone()
    {
        foreach ($this->routes as $name => $route) {
            $this->routes[$name] = clone $route;
        }
    }

    public function add(Route $route)
    {
        $name = $route->name();

        unset($this->routes[$name]);

        $this->routes[$name] = $route;
    }

    public function addCollection(RouteCollection $collection)
    {
        foreach ($collection as $name => $route) {
            unset($this->routes[$name]);
            $this->routes[$name] = $route;
        }
    }

    public function count()
    {
        return count($this->routes);
    }

    public function get($name)
    {
        return isset($this->routes[$name]) ? $this->routes[$name] : null;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->routes);
    }
}
