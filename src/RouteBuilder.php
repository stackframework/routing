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
     * @var mixed
     */
    private $auth;

    /**
     * @var array
     */
    private $defaults = [];

    /**
     * @var mixed
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
     * @var null|bool
     */
    private $secure = null;

    /**
     * @var null|string
     */
    private $wildcard = null;

    /**
     * RouteBuilder constructor.
     *
     * @param Route $route
     */
    public function __construct(Route $route = null)
    {
        if ($route !== null) {
            $this->init($route);
        }
    }

    /**
     * Adds a GET route.
     *
     * @param string $name
     * @param string $path
     * @param array  $requirements
     * @param mixed  $handler
     *
     * @return Route
     */
    public function get($name, $path, $requirements = [], $handler = null)
    {
        return $this->route($name, $path, $requirements, $handler, 'GET');
    }

    /**
     * Adds a DELETE route.
     *
     * @param string $name
     * @param string $path
     * @param array  $requirements
     * @param mixed  $handler
     *
     * @return Route
     */
    public function delete($name, $path, $requirements = [], $handler = null)
    {
        return $this->route($name, $path, $requirements, $handler, 'DELETE');
    }

    /**
     * Adds a HEAD route.
     *
     * @param string $name
     * @param string $path
     * @param array  $requirements
     * @param mixed  $handler
     *
     * @return Route
     */
    public function head($name, $path, $requirements = [], $handler = null)
    {
        return $this->route($name, $path, $requirements, $handler, 'HEAD');
    }

    /**
     * Adds an OPTIONS route.
     *
     * @param string $name
     * @param string $path
     * @param array  $requirements
     * @param mixed  $handler
     *
     * @return Route
     */
    public function options($name, $path, $requirements = [], $handler = null)
    {
        return $this->route($name, $path, $requirements, $handler, 'OPTIONS');
    }

    /**
     * Adds a PATCH route.
     *
     * @param string $name
     * @param string $path
     * @param array  $requirements
     * @param mixed  $handler
     *
     * @return Route
     */
    public function patch($name, $path, $requirements = [], $handler = null)
    {
        return $this->route($name, $path, $requirements, $handler, 'PATCH');
    }

    /**
     * Adds a POST route.
     *
     * @param string $name
     * @param string $path
     * @param array  $requirements
     * @param mixed  $handler
     *
     * @return Route
     */
    public function post($name, $path, $requirements = [], $handler = null)
    {
        return $this->route($name, $path, $requirements, $handler, 'POST');
    }

    /**
     * Adds a PUT route.
     *
     * @param string $name
     * @param string $path
     * @param array  $requirements
     * @param mixed  $handler
     *
     * @return Route
     */
    public function put($name, $path, $requirements = [], $handler = null)
    {
        return $this->route($name, $path, $requirements, $handler, 'PUT');
    }

    /**
     * Adds a generic route.
     *
     * @param string $name
     * @param string $path
     * @param array  $requirements
     * @param mixed  $handler
     * @param array  $allows
     *
     * @return Route
     */
    public function route($name, $path, $requirements = [], $handler = null, $allows = [])
    {
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
     * @return $this
     */
    public function accepts($accepts)
    {
        $this->accepts = array_merge($this->accepts, (array) $accepts);

        return $this;
    }

    /**
     * Merges with the existing allowed methods.
     *
     * @param string|array $allows
     *
     * @return $this
     */
    public function allows($allows)
    {
        $this->allows = array_merge($this->allows, (array) $allows);

        return $this;
    }

    /**
     * Merges with the existing attributes.
     *
     * @param array $attributes
     *
     * @return $this
     */
    public function attributes(array $attributes)
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return $this;
    }

    /**
     * Sets the auth value.
     *
     * @param mixed $auth
     *
     * @return $this
     */
    public function auth($auth)
    {
        $this->auth = $auth;

        return $this;
    }

    /**
     * Merges with the existing default values for attributes.
     *
     * @param array $defaults
     *
     * @return $this
     */
    public function defaults(array $defaults)
    {
        $this->defaults = array_merge($this->defaults, $defaults);

        return $this;
    }

    /**
     * The route leads to this handler.
     *
     * @param mixed $handler
     *
     * @return $this
     */
    public function handler($handler)
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
     * @return $this
     */
    public function host($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Sets whether or not this route should be used for matching.
     *
     * @param bool $isRoutable
     *
     * @return $this
     */
    public function isRoutable($isRoutable = true)
    {
        $this->isRoutable = (bool) $isRoutable;

        return $this;
    }

    /**
     * Sets the route name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function name($name)
    {
        $this->name = $this->namePrefix.$name;

        return $this;
    }

    /**
     * Sets the route name prefix.
     *
     * @param string $namePrefix
     *
     * @return $this
     */
    public function namePrefix($namePrefix)
    {
        $this->namePrefix = $namePrefix;

        return $this;
    }

    /**
     * Sets the route path.
     *
     * @param string $path
     *
     * @return $this
     */
    public function path($path)
    {
        $this->path = $this->pathPrefix.$path;

        return $this;
    }

    /**
     * Sets the path name prefix.
     *
     * @param string $pathPrefix
     *
     * @return $this
     */
    public function pathPrefix($pathPrefix)
    {
        $this->pathPrefix = $pathPrefix;

        return $this;
    }

    /**
     * Merges with the existing requirements.
     *
     * @param array $requirements
     *
     * @return $this
     */
    public function requirements(array $requirements)
    {
        $this->requirements = array_merge($this->requirements, $requirements);

        return $this;
    }

    /**
     * Sets whether or not the route must be secure.
     *
     * @param bool $secure
     *
     * @return $this
     */
    public function secure($secure = true)
    {
        $this->secure = ($secure === null) ? null : (bool) $secure;

        return $this;
    }

    /**
     * Sets the name of the wildcard.
     *
     * @param $wildcard
     *
     * @return $this
     */
    public function wildcard($wildcard)
    {
        $this->wildcard = $wildcard;

        return $this;
    }

    /**
     * Build and return a route.
     *
     * @return Route
     */
    public function build()
    {
        return new Route(
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
     * Init from existing route.
     *
     * @param Route $route
     */
    private function init(Route $route)
    {
        $this->name($route->name())
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
    }
}
