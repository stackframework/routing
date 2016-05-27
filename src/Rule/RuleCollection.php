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

class RuleCollection implements \Iterator
{
    private $rules = [];

    /**
     * RuleIterator constructor.
     * @param array $rules
     */
    public function __construct(array $rules = [])
    {
        $this->set($rules);
    }

    public function append(callable $rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        $rule = current($this->rules);
        if ($rule instanceof Rule) {
            return $rule;
        }

        $key     = key($this->rules);
        $factory = $this->rules[$key];
        $rule    = $factory();
        if ($rule instanceof Rule) {
            $this->rules[$key] = $rule;
            return $rule;
        }
        
        throw new \UnexpectedValueException(
            sprintf(
                'Expected RuleInterface, got %s for key %s',
                get_class($rule),
                $key
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function key()
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

    public function set(array $rules)
    {
        $this->rules = [];
        foreach ($rules as $rule) {
            $this->append($rule);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return current($this->rules) !== false;
    }
}
