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
     * @var null|bool
     */
    private $secure = null;

    /**
     * @var null|string
     */
    private $wildcard = null;

    /**
     * Route constructor.
     *
     * @param string      $name
     * @param string      $path
     * @param mixed       $handler
     * @param array       $defaults
     * @param array       $requirements
     * @param string      $host
     * @param array       $accepts
     * @param array       $allows
     * @param array       $attributes
     * @param null|string $auth
     * @param null|string $wildcard
     * @param null|string $secure
     * @param bool        $isRoutable
     */
    public function __construct(
        $name,
        $path,
        $handler = null,
        array $defaults = [],
        array $requirements = [],
        $host = '',
        array $accepts = [],
        array $allows = [],
        array $attributes = [],
        $auth = null,
        $secure = null,
        $wildcard = null,
        $isRoutable = true
    ) {
        $this->name    = $name;
        $this->path    = $path;
        $this->handler = $handler;

        $this->defaults     = $defaults;
        $this->requirements = $requirements;
        $this->host         = $host;
        $this->accepts      = $accepts;
        $this->allows       = $allows;
        $this->attributes   = $attributes;
        $this->auth         = $auth;
        $this->secure       = $secure;
        $this->wildcard     = $wildcard;
        $this->isRoutable   = $isRoutable;
    }

    /**
     * Returns accepted headers of route.
     *
     * @return array
     */
    public function accepts()
    {
        return $this->accepts;
    }

    /**
     * Returns allows methods of route.
     *
     * @return array
     */
    public function allows()
    {
        return $this->allows;
    }

    /**
     * Returns the attributes of route.
     *
     * @return array
     */
    public function attributes()
    {
        return $this->attributes;
    }

    /**
     * Returns the authentication/authorization values.
     *
     * @return mixed
     */
    public function auth()
    {
        return $this->auth;
    }

    /**
     * Returns default attribute values.
     *
     * @return array
     */
    public function defaults()
    {
        return $this->defaults;
    }

    /**
     * Returns the handler of route.
     *
     * @return mixed
     */
    public function handler()
    {
        return $this->handler;
    }

    /**
     * Returns the host of route.
     *
     * @return mixed
     */
    public function host()
    {
        return $this->host;
    }

    /**
     * Return true if this route can be matched; if not, it
     * can be used only to generate a path.
     *
     * @return bool
     */
    public function isRoutable()
    {
        return $this->isRoutable;
    }

    /**
     * Returns the name of route.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Returns the pattern for the path.
     *
     * @return string
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * Returns the requirements for the route.
     *
     * @return array
     */
    public function requirements()
    {
        return $this->requirements;
    }

    /**
     * Return true if this route respond on secure protocol.
     *
     * @return null|bool
     */
    public function secure()
    {
        return $this->secure;
    }

    /**
     * Returns the wildcard name of route.
     *
     * @return null
     */
    public function wildcard()
    {
        return $this->wildcard;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
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
