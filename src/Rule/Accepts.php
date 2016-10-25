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
 * A rule for "Accept" headers.
 *
 * @author Andrzej Kostrzewa <andkos11@gmail.com>
 */
class Accepts implements Rule
{
    /**
     * Check that the request Accept headers match one Route accept value.
     *
     * @param ServerRequestInterface $request
     * @param Route                  $route
     *
     * @return bool
     */
    public function __invoke(ServerRequestInterface $request, Route $route) : bool
    {
        $routeAccepts = $route->accepts();
        $requestAccepts = $request->getHeader('Accept');

        if (!($routeAccepts || $requestAccepts)) {
            return true;
        }

        return $this->matches($routeAccepts, $requestAccepts);
    }

    /**
     * Is the Accept header a match?
     *
     * @param string $type
     * @param string $header
     *
     * @return bool
     */
    private function match(string $type, string $header) : bool
    {
        list($type, $subType) = explode('/', $type);

        $type                 = preg_quote($type);
        $subType              = preg_quote($subType);
        $regex                = "#$type/($subType|\*)(;q=(\d\.\d))?#";

        $match                = preg_match($regex, $header, $matches);
        if (!$match) {
            return false;
        }

        if (isset($matches[3])) {
            return $matches[3] !== '0.0';
        }

        return true;
    }

    /**
     * Does what the route accepts match what the request accepts?
     *
     * @param array $routeAccepts
     * @param array $requestAccepts
     *
     * @return bool
     */
    private function matches(array $routeAccepts, array $requestAccepts) : bool
    {
        $requestAccepts = implode(';', $requestAccepts);
        if ($this->match('*/*', $requestAccepts)) {
            return true;
        }

        foreach ($routeAccepts as $type) {
            if ($this->match($type, $requestAccepts)) {
                return true;
            }
        }

        return false;
    }
}
