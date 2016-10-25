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

namespace Stack\Routing\Matcher;

use Psr\Http\Message\ServerRequestInterface;
use Stack\Routing\Exception;
use Stack\Routing\Route;

/**
 * Matcher is the interface that all URL matcher classes must implement.
 *
 * @author Andrzej Kostrzewa <andkos11@gmail.com>
 */
interface Matcher
{
    /**
     * Tries to match a URL path with a set of routes.
     *
     * @param ServerRequestInterface $request
     *
     * @return Route
     * @throws Exception\ResourceNotFound
     */
    public function match(ServerRequestInterface $request) : Route;
}
