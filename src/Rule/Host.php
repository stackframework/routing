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

class Host implements Rule
{
    public function __invoke(ServerRequestInterface $request, Route $route)
    {
        if (!$route->host()) {
            return true;
        }

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
        $regex = str_replace('.', '\\.', $route->host());
        $regex = '#^'. $regex . '$#';

        return $regex;
    }
}
