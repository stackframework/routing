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

class Secure implements Rule
{
    public function __invoke(ServerRequestInterface $request, Route $route)
    {
        if ($route->secure() === null) {
            return true;
        }

        $server = $request->getServerParams();
        $secure = $this->https($server) || $this->port443($server);

        return $route->secure() === $secure;
    }

    private function https($server)
    {
        return isset($server['HTTPS'])
            && $server['HTTPS'] === 'on';
    }

    private function port443($server)
    {
        return isset($server['SERVER_PORT'])
            && $server['SERVER_PORT'] === 443;
    }
}
