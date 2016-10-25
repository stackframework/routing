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
 * Interface for rules.
 *
 * @author Andrzej Kostrzewa <andkos11@gmail.com>
 */
interface Rule
{
    /**
     * Check if the Request matches the Route.
     *
     * @param ServerRequestInterface $request
     * @param Route                  $route
     *
     * @return bool
     */
    public function __invoke(ServerRequestInterface $request, Route $route) : bool;
}
