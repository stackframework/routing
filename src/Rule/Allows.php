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

class Allows implements Rule
{
    public function __invoke(ServerRequestInterface $request, Route $route)
    {
        $routeAllows = $route->allows();
        if (!$routeAllows) {
            return true;
        }

        $requestMethod = $request->getMethod() ?: 'GET';

        return in_array($requestMethod, $routeAllows);
    }
}
