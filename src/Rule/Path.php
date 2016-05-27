<?php
/**
 * This file is part of the Stack package.
 *
 * (c) Andrzej Kostrzewa <andkos11@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Stack\Routing\Rule;

use Psr\Http\Message\ServerRequestInterface;
use Stack\Routing\Route;

class Path implements Rule
{
    private $basePath;

    private $regex;

    /**
     * Path constructor.
     * @param $basePath
     */
    public function __construct($basePath = null)
    {
        $this->basePath = $basePath;
    }

    public function __invoke(ServerRequestInterface $request, Route $route)
    {
        $match = preg_match(
            $this->buildRegex($route),
            $request->getUri()->getHost(),
            $matches
        );

        if (!$match) {
            return false;
        }

        return true;
    }

    private function buildRegex(Route $route)
    {
        $this->regex = $this->basePath . $route->path();
        $this->regex = $this->withWildcardRegex($route);
        $this->regex = '#^' . $this->regex . '$#';

        return $this->regex;
    }

    private function withWildcardRegex(Route $route)
    {
        if (!$route->wildcard()) {
            return;
        }

        return rtrim($this->regex, '/')
            . "(/(?P<{$route->wildcard()}>.*))?";
    }
}
