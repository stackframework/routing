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
 * Helper to create and configure a Route.
 *
 * @author Andrzej Kostrzewa <andkos11@gmail.com>
 */
final class RouteBuilder
{
    /**
     * @var array
     */
    private $accepts = [];

    /**
     * @var array
     */
    private $allows = [];

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @var array
     */
    private $auth = [];

    /**
     * @var array
     */
    private $defaults = [];

    /**
     * @var callable
     */
    private $handler;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $namePrefix;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $pathPrefix;

    /**
     * @var bool
     */
    private $isRoutable = true;

    /**
     * @var array
     */
    private $requirements = [];

    /**
     * @var bool
     */
    private $secure;

    /**
     * @var string
     */
    private $wildcard;

    /**
     * Build and return a route.
     *
     * @return Route
     */
    public function build() : Route
    {
        return Route::createWithOptional(
            $this->name,
            $this->path,
            $this->handler,
            $this->defaults,
            $this->requirements,
            $this->host,
            $this->accepts,
            $this->allows,
            $this->attributes,
            $this->auth,
            $this->secure,
            $this->wildcard,
            $this->isRoutable
        );
    }

    /**
     * Create from existing route.
     *
     * @param  Route|null $route
     *
     * @return RouteBuilder
     */
    public static function createFromRoute(Route $route = null) : RouteBuilder
    {
        $routeBuilder = new RouteBuilder();

        if ($route === null) {
            return $routeBuilder;
        }

        $routeBuilder->name($route->name())
            ->path($route->path())
            ->handler($route->handler())
            ->defaults($route->defaults())
            ->requirements($route->requirements())
            ->host($route->host())
            ->accepts($route->accepts())
            ->allows($route->allows())
            ->attributes($route->attributes())
            ->auth($route->auth())
            ->secure($route->secure())
            ->wildcard($route->wildcard())
            ->isRoutable($route->isRoutable());

        return $routeBuilder;
    }

    /**
     * Adds a GET route.
     *
     * @param string   $name
     * @param string   $path
     * @param array    $requirements
     * @param callable $handler
     *
     * @return Route
     */
    public function get(string $name, string $path, array $requirements = [], callable $handler = null) : Route
    {
        return $this->route($name, $path, $requirements, $handler, 'GET');
    }

    /**
     * Adds a DELETE route.
     *
     * @param string   $name
     * @param string   $path
     * @param array    $requirements
     * @param callable $handler
     *
     * @return Route
     */
    public function delete(string $name, string $path, array $requirements = [], callable $handler = null) : Route
    {
        return $this->route($name, $path, $requirements, $handler, 'DELETE');
    }

    /**
     * Adds a HEAD route.
     *
     * @param string   $name
     * @param string   $path
     * @param array    $requirements
     * @param callable $handler
     *
     * @return Route
     */
    public function head(string $name, string $path, array $requirements = [], callable $handler = null) : Route
    {
        return $this->route($name, $path, $requirements, $handler, 'HEAD');
    }

    /**
     * Adds an OPTIONS route.
     *
     * @param string   $name
     * @param string   $path
     * @param array    $requirements
     * @param callable $handler
     *
     * @return Route
     */
    public function options(string $name, string $path, array $requirements = [], callable $handler = null) : Route
    {
        return $this->route($name, $path, $requirements, $handler, 'OPTIONS');
    }

    /**
     * Adds a PATCH route.
     *
     * @param string   $name
     * @param string   $path
     * @param array    $requirements
     * @param callable $handler
     *
     * @return Route
     */
    public function patch(string $name, string $path, array $requirements = [], callable $handler = null) : Route
    {
        return $this->route($name, $path, $requirements, $handler, 'PATCH');
    }

    /**
     * Adds a POST route.
     *
     * @param string   $name
     * @param string   $path
     * @param array    $requirements
     * @param callable $handler
     *
     * @return Route
     */
    public function post(string $name, string $path, array $requirements = [], callable $handler = null) : Route
    {
        return $this->route($name, $path, $requirements, $handler, 'POST');
    }

    /**
     * Adds a PUT route.
     *
     * @param string   $name
     * @param string   $path
     * @param array    $requirements
     * @param callable $handler
     *
     * @return Route
     */
    public function put(string $name, string $path, array $requirements = [], callable $handler = null) : Route
    {
        return $this->route($name, $path, $requirements, $handler, 'PUT');
    }

    /**
     * Adds a generic route.
     *
     * @param string   $name
     * @param string   $path
     * @param array    $requirements
     * @param callable $handler
     * @param array    $allows
     *
     * @return Route
     */
    public function route(
        string $name,
        string $path,
        array $requirements = [],
        callable $handler   = null,
        array $allows       = []
    ) : Route {
        $routeBuilder               = clone $this;
        $routeBuilder->name         = $routeBuilder->namePrefix.$name;
        $routeBuilder->path         = rtrim($routeBuilder->pathPrefix, '/').$path;
        $routeBuilder->requirements = $requirements;
        $routeBuilder->handler      = $handler;
        $routeBuilder->allows       = (array) $allows;

        return $routeBuilder->build();
    }

    /**
     * Merges with the existing content types.
     *
     * @param string|array $accepts
     *
     * @return RouteBuilder
     */
    public function accepts($accepts) : RouteBuilder
    {
        $this->accepts = array_merge($this->accepts, (array) $accepts);

        return $this;
    }

    /**
     * Merges with the existing allowed methods.
     *
     * @param string|array $allows
     *
     * @return RouteBuilder
     */
    public function allows($allows) : RouteBuilder
    {
        $this->allows = array_merge($this->allows, (array) $allows);

        return $this;
    }

    /**
     * Merges with the existing attributes.
     *
     * @param array $attributes
     *
     * @return RouteBuilder
     */
    public function attributes(array $attributes) : RouteBuilder
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return $this;
    }

    /**
     * Sets the auth value.
     *
     * @param array $auth
     *
     * @return RouteBuilder
     */
    public function auth(array $auth) : RouteBuilder
    {
        $this->auth = $auth;

        return $this;
    }

    /**
     * Merges with the existing default values for attributes.
     *
     * @param array $defaults
     *
     * @return RouteBuilder
     */
    public function defaults(array $defaults) : RouteBuilder
    {
        $this->defaults = array_merge($this->defaults, $defaults);

        return $this;
    }

    /**
     * The route leads to this handler.
     *
     * @param callable $handler
     *
     * @return RouteBuilder
     */
    public function handler($handler) : RouteBuilder
    {
        if ($handler === null) {
            $handler = $this->name;
        }

        $this->handler = $handler;

        return $this;
    }

    /**
     * Sets the host.
     *
     * @param string $host
     *
     * @return RouteBuilder
     */
    public function host($host) : RouteBuilder
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Sets whether or not this route should be used for matching.
     *
     * @param bool $isRoutable
     *
     * @return RouteBuilder
     */
    public function isRoutable($isRoutable = true) : RouteBuilder
    {
        $this->isRoutable = (bool) $isRoutable;

        return $this;
    }

    /**
     * Sets the route name.
     *
     * @param string $name
     *
     * @return RouteBuilder
     */
    public function name($name) : RouteBuilder
    {
        $this->name = $this->namePrefix.$name;

        return $this;
    }

    /**
     * Sets the route name prefix.
     *
     * @param string $namePrefix
     *
     * @return RouteBuilder
     */
    public function namePrefix($namePrefix) : RouteBuilder
    {
        $this->namePrefix = $namePrefix;

        return $this;
    }

    /**
     * Sets the route path.
     *
     * @param string $path
     *
     * @return RouteBuilder
     */
    public function path($path) : RouteBuilder
    {
        $this->path = $this->pathPrefix.$path;

        return $this;
    }

    /**
     * Sets the path name prefix.
     *
     * @param string $pathPrefix
     *
     * @return RouteBuilder
     */
    public function pathPrefix($pathPrefix) : RouteBuilder
    {
        $this->pathPrefix = $pathPrefix;

        return $this;
    }

    /**
     * Merges with the existing requirements.
     *
     * @param array $requirements
     *
     * @return RouteBuilder
     */
    public function requirements(array $requirements) : RouteBuilder
    {
        $this->requirements = array_merge($this->requirements, $requirements);

        return $this;
    }

    /**
     * Sets whether or not the route must be secure.
     *
     * @param bool $secure
     *
     * @return RouteBuilder
     */
    public function secure($secure = true) : RouteBuilder
    {
        $this->secure = ($secure === null) ? null : (bool) $secure;

        return $this;
    }

    /**
     * Sets the name of the wildcard.
     *
     * @param $wildcard
     *
     * @return RouteBuilder
     */
    public function wildcard($wildcard) : RouteBuilder
    {
        $this->wildcard = $wildcard;

        return $this;
    }
}
