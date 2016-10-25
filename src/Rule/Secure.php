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
 * A rule for HTTPS/SSL/TLS.
 *
 * @author Andrzej Kostrzewa <andkos11@gmail.com>
 */
class Secure implements Rule
{
    /**
     * Checks that the Route `$secure` matches the corresponding server values.
     *
     * @param ServerRequestInterface $request
     * @param Route                  $route
     *
     * @return bool
     */
    public function __invoke(ServerRequestInterface $request, Route $route) : bool
    {
        if ($route->secure() === null) {
            return true;
        }

        $server = $request->getServerParams();
        $secure = $this->https($server) || $this->port443($server);

        return $route->secure() === $secure;
    }

    /**
     * Is HTTPS on?
     *
     * @param array $server
     *
     * @return bool
     */
    private function https(array $server) : bool
    {
        return isset($server['HTTPS'])
            && $server['HTTPS'] === 'on';
    }

    /**
     * Is the request on port 443?
     *
     * @param array $server
     *
     * @return bool
     */
    private function port443(array $server) : bool
    {
        return isset($server['SERVER_PORT'])
            && $server['SERVER_PORT'] === 443;
    }
}
