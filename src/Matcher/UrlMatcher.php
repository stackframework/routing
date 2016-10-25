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

namespace Stack\Routing\Matcher;

use Psr\Http\Message\ServerRequestInterface;
use Stack\Routing\Exception;
use Stack\Routing\Route;
use Stack\Routing\RouteCollection;
use Stack\Routing\Rule\RuleCollection;

/**
 * UrlMatcher matches URL based on a set of routes.
 *
 * @author Andrzej Kostrzewa <andkos11@gmail.com>
 */
final class UrlMatcher implements Matcher
{
    /**
     * @var RouteCollection
     */
    private $routes;

    /**
     * @var RuleCollection
     */
    private $ruleCollection;

    /**
     * UrlMatcher constructor.
     *
     * @param RouteCollection $routes
     * @param RuleCollection  $ruleCollection
     */
    public function __construct(RouteCollection $routes, RuleCollection $ruleCollection)
    {
        $this->routes         = $routes;
        $this->ruleCollection = $ruleCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function match(ServerRequestInterface $request) : Route
    {
        foreach ($this->routes as $name => $prototype) {
            $route = $this->matchRoute($request, $prototype);
            if ($route) {
                return $route;
            }
        }

        throw Exception::ResourceNotFound($request->getUri()->getPath());
    }

    /**
     * Match a request to a route.
     *
     * @param ServerRequestInterface $request
     * @param Route                  $prototype
     *
     * @return Route|void
     * @throws Exception\RuleNotAllowed
     */
    private function matchRoute(ServerRequestInterface $request, Route $prototype)
    {
        if (!$prototype->isRoutable()) {
            return;
        }

        $route = clone $prototype;

        return $this->applyRules($request, $route);
    }

    /**
     * Does the request match a route per the matching rules?
     *
     * @param ServerRequestInterface $request
     * @param Route                  $route
     *
     * @return Route
     * @throws Exception\RuleNotAllowed
     */
    private function applyRules(ServerRequestInterface $request, Route $route) : Route
    {
        foreach ($this->ruleCollection as $rule) {
            if (!$rule($request, $route)) {
                throw Exception::RuleNotAllowed(
                    $request->getUri()->getPath(),
                    get_class($rule),
                    $route->name()
                 );
            }
        }

        return $route;
    }
}
