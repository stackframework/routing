<?php
/**
 * This file is part of the Stack package.
 *
 * (c) Andrzej Kostrzewa <andkos11@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Stack\Routing;

/**
 * Generic package exception.
 *
 * @author Andrzej Kostrzewa <andkos11@gmail.com>
 */
class Exception extends \Exception
{
    /**
     * The rule was not allowed.
     *
     * @param $path
     * @param $class
     * @param $route
     *
     * @return Exception\RuleNotAllowed
     *
     * @throws Exception\RuleNotAllowed
     */
    public static function RuleNotAllowed($path, $class, $route)
    {
        throw new Exception\RuleNotAllowed(
            sprintf(
                '%s FAILED %s ON %s',
                $path,
                $class,
                $route
            )
        );
    }

    /**
     * The resource was not found.
     *
     * @param $path
     *
     * @return Exception\ResourceNotFound
     *
     * @throws Exception\ResourceNotFound
     */
    public static function ResourceNotFound($path)
    {
        throw new Exception\ResourceNotFound(
            sprintf('No routes found for "%s".', $path)
        );
    }
}
