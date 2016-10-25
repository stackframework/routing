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
 * A rule for HTTP methods.
 *
 * @author Andrzej Kostrzewa <andkos11@gmail.com>
 */
class Allows implements Rule
{
    /**
     * Does the server request method match an allowed route method?
     *
     * @param ServerRequestInterface $request
     * @param Route                  $route
     *
     * @return bool
     */
    public function __invoke(ServerRequestInterface $request, Route $route) : bool
    {
        $routeAllows = $route->allows();
        if (!$routeAllows) {
            return true;
        }

        $requestMethod = $request->getMethod() ?: 'GET';

        return in_array($requestMethod, $routeAllows);
    }
}
