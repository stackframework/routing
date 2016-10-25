<?php
/**
 * This file is part of the Stack package.
 *
 * (c) Andrzej Kostrzewa <andkos11@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Stack\Routing\Rule;

use Psr\Http\Message\ServerRequestInterface;
use Stack\Routing\Route;

/**
 * A rule for the HTTP host.
 *
 * @author Andrzej Kostrzewa <andkos11@gmail.com>
 */
class Host implements Rule
{
    /**
     * Checks that the Request host matches the Route host.
     *
     * @param ServerRequestInterface $request
     * @param Route                  $route
     *
     * @return bool
     */
    public function __invoke(ServerRequestInterface $request, Route $route) : bool
    {
        if (!$route->host()) {
            return true;
        }

        $match = preg_match(
            self::buildRegexOfRoute($route),
            $request->getUri()->getHost(),
            $matches
        );

        if (!$match) {
            return false;
        }

        return true;
    }

    /**
     * Builds the regular expression for the route host.
     *
     * @param Route $route
     *
     * @return string
     */
    private static function buildRegexOfRoute(Route $route) : string
    {
        $regex = str_replace('.', '\\.', $route->host());
        $regex = '#^'.$regex.'$#';

        return $regex;
    }
}
