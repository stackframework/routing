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
 * A Route describes a route and its parameters.
 *
 * @author Andrzej Kostrzewa <andkos11@gmail.com>
 */
final class Route implements \Serializable
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
    private $path;

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
    private $secure = false;

    /**
     * @var string
     */
    private $wildcard;

    /**
     * Route constructor.
     *
     * @param string $name
     * @param string $path
     * @param mixed  $handler
     */
    public function __construct(
        string $name,
        string $path,
        callable $handler = null
    ) {
        $this->name    = $name;
        $this->path    = $path;
        $this->handler = $handler;
    }

    /**
     * Create Route with optional parameters
     *
     * @param string   $name
     * @param string   $path
     * @param callable $handler
     * @param array    $defaults
     * @param array    $requirements
     * @param string   $host
     * @param array    $accepts
     * @param array    $allows
     * @param array    $attributes
     * @param array    $auth
     * @param bool     $secure
     * @param string   $wildcard
     * @param bool     $isRoutable
     *
     * @return Route
     */
    public static function createWithOptional(
        string $name,
        string $path,
        callable $handler   = null,
        array $defaults     = [],
        array $requirements = [],
        string $host        = '',
        array $accepts      = [],
        array $allows       = [],
        array $attributes   = [],
        array $auth         = [],
        bool  $secure       = false,
        string $wildcard    = '',
        bool $isRoutable    = true
    ) {
        $route               = new Route($name, $path, $handler);
        $route->defaults     = $defaults;
        $route->requirements = $requirements;
        $route->host         = $host;
        $route->accepts      = $accepts;
        $route->allows       = $allows;
        $route->attributes   = $attributes;
        $route->auth         = $auth;
        $route->secure       = $secure;
        $route->wildcard     = $wildcard;
        $route->isRoutable   = $isRoutable;

        return $route;
    }

    /**
     * Returns accepted headers of route.
     *
     * @return array
     */
    public function accepts() : array
    {
        return $this->accepts;
    }

    /**
     * Returns allows methods of route.
     *
     * @return array
     */
    public function allows() : array
    {
        return $this->allows;
    }

    /**
     * Returns the attributes of route.
     *
     * @return array
     */
    public function attributes() : array
    {
        return $this->attributes;
    }

    /**
     * Returns the authentication/authorization values.
     *
     * @return array
     */
    public function auth() : array
    {
        return $this->auth;
    }

    /**
     * Returns default attribute values.
     *
     * @return array
     */
    public function defaults() : array
    {
        return $this->defaults;
    }

    /**
     * Returns the handler of route.
     *
     * @return callable
     */
    public function handler() : callable
    {
        return $this->handler;
    }

    /**
     * Returns the host of route.
     *
     * @return string
     */
    public function host() : string
    {
        return $this->host;
    }

    /**
     * Return true if this route can be matched; if not, it
     * can be used only to generate a path.
     *
     * @return bool
     */
    public function isRoutable() : bool
    {
        return $this->isRoutable;
    }

    /**
     * Returns the name of route.
     *
     * @return string
     */
    public function name() : string
    {
        return $this->name;
    }

    /**
     * Returns the pattern for the path.
     *
     * @return string
     */
    public function path() : string
    {
        return $this->path;
    }

    /**
     * Returns the requirements for the route.
     *
     * @return array
     */
    public function requirements() : array
    {
        return $this->requirements;
    }

    /**
     * Return true if this route respond on secure protocol.
     *
     * @return bool
     */
    public function secure() : bool
    {
        return $this->secure;
    }

    /**
     * Returns the wildcard name of route.
     *
     * @return string
     */
    public function wildcard() : string
    {
        return $this->wildcard;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize() : string
    {
        return serialize([
            'name'         => $this->name,
            'path'         => $this->path,
            'host'         => $this->host,
            'defaults'     => $this->defaults,
            'requirements' => $this->requirements,
            'accepts'      => $this->accepts,
            'allows'       => $this->allows,
            'attributes'   => $this->attributes,
            'auth'         => $this->auth,
            'secure'       => $this->secure,
            'handler'      => $this->handler,
            'wildcard'     => $this->wildcard,
            'isRoutable'   => $this->isRoutable,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $data               = unserialize($serialized);
        $this->name         = $data['name'];
        $this->path         = $data['path'];
        $this->host         = $data['host'];
        $this->defaults     = $data['defaults'];
        $this->requirements = $data['requirements'];
        $this->accepts      = $data['accepts'];
        $this->allows       = $data['allows'];
        $this->attributes   = $data['attributes'];
        $this->auth         = $data['auth'];
        $this->secure       = $data['secure'];
        $this->handler      = $data['handler'];
        $this->wildcard     = $data['wildcard'];
        $this->isRoutable   = $data['isRoutable'];
    }
}
