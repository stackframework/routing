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

namespace Stack\Routing\Rule;

use Psr\Http\Message\ServerRequestInterface;
use Stack\Routing\Route;

/**
 * A rule for the URL path.
 *
 * @author Andrzej Kostrzewa <andkos11@gmail.com>
 */
class Path implements Rule
{
    /**
     * @var string|null
     */
    private static $basePath;

    /**
     * Path constructor.
     *
     * @param string $basePath
     */
    public function __construct(string $basePath = null)
    {
        self::$basePath = $basePath;
    }

    /**
     * Checks that the Request path matches the Route path.
     *
     * @param ServerRequestInterface $request
     * @param Route                  $route
     *
     * @return bool
     */
    public function __invoke(ServerRequestInterface $request, Route $route) : bool
    {
        $match = preg_match(
            self::buildRegexOfRoute($route),
            $request->getUri()->getPath(),
            $matches
        );

        if (!$match) {
            return false;
        }

        return true;
    }

    /**
     * Builds the regular expression for the route path.
     *
     * @param Route $route
     *
     * @return string
     */
    private static function buildRegexOfRoute(Route $route) : string
    {
        $regex = self::$basePath.$route->path();
        $regex = self::withWildcardRegex($regex, $route);
        $regex = '#^'.$regex.'$#';

        return $regex;
    }

    /**
     * Adds a wildcard subpattern to the end of the regex.
     *
     * @param string $regex
     * @param Route $route
     *
     * @return string
     */
    private static function withWildcardRegex(string $regex, Route $route) : string
    {
        if (!$route->wildcard()) {
            return $regex;
        }

        return rtrim($regex, '/')
            ."(/(?P<{$route->wildcard()}>.*))?";
    }
}
