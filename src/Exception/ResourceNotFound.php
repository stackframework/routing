<?php
/**
 * This file is part of the Stack package.
 *
 * (c) Andrzej Kostrzewa <andkos11@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Stack\Routing\Exception;

/**
 * The resource was not found.
 *
 * This exception should trigger an HTTP 404 response in your application code.
 *
 * @author Andrzej Kostrzewa <andkos11@gmail.com>
 */
class ResourceNotFound extends \RuntimeException
{
}
