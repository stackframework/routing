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

class Accepts implements Rule
{
    public function __invoke(ServerRequestInterface $request, Route $route)
    {
        $routeAccepts = $route->accepts();
        if (!$routeAccepts) {
            return true;
        }

        $requestAccepts = $request->getHeader('Accept');
        if (!$requestAccepts) {
            return true;
        }

        return $this->matches($routeAccepts, $requestAccepts);
    }

    private function match($type, $header)
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

    private function matches(array $routeAccepts, array $requestAccepts)
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
