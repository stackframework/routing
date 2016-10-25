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

use Stack\Routing\Exception;

/**
 * Collection of Rule.
 *
 * @author Andrzej Kostrzewa <andkos11@gmail.com>
 */
class RuleCollection implements \Iterator
{
    /**
     * @var array
     */
    private $rules = [];

    /**
     * Create a collection of rule.
     *
     * @param array $rules
     *
     * @return RuleCollection
     */
    public static function create(array $rules = []) : RuleCollection
    {
        $ruleCollection = new RuleCollection();
        foreach ($rules as $rule) {
            $ruleCollection->append($rule);
        }

        return $ruleCollection;
    }

    /**
     * Append rule to collection.
     *
     * @param callable $rule
     */
    public function append(callable $rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * {@inheritdoc}
     */
    public function current() : Rule
    {
        $rule = current($this->rules);
        if ($rule instanceof Rule) {
            return $rule;
        }

        $key     = $this->key();
        $factory = $this->rules[$key];
        $rule    = $factory();
        if ($rule instanceof Rule) {
            $this->rules[$key] = $rule;

            return $rule;
        }

        throw Exception::RuleNotFound(get_class($rule), $key);
    }

    /**
     * {@inheritdoc}
     */
    public function key() : string
    {
        return key($this->rules);
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        next($this->rules);
    }

    /**
     * Prepend rule from collection.
     *
     * @param callable $rule
     */
    public function prepend(callable $rule)
    {
        array_unshift($this->rules, $rule);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        reset($this->rules);
    }

    /**
     * {@inheritdoc}
     */
    public function valid() : bool
    {
        return current($this->rules) !== false;
    }
}
