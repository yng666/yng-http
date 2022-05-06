<?php

namespace Yng\Http\Message\Bags;

use ArrayAccess;
use Countable;
use IteratorAggregate;

/**
 * @class   ParameterBag
 * @author  Yng
 * @date    2022/04/23
 * @time    17:38
 * @package Yng\Http\Message\Bags
 */
class ParameterBag implements IteratorAggregate, Countable, ArrayAccess
{
    /**
     * @var array
     */
    protected array $parameters;

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->replace($parameters);
    }

    /**
     * @return int[]|string[]
     */
    public function keys()
    {
        return array_keys($this->parameters);
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function add(array $parameters = [])
    {
        $this->parameters = array_replace($this->parameters, $parameters);
    }

    /**
     * @param string $key
     * @param        $default
     *
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        return $this->parameters[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param        $value
     *
     * @return void
     */
    public function set(string $key, $value)
    {
        $this->parameters[$key] = $value;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key)
    {
        return isset($this->parameters[$key]);
    }

    /**
     * @param string $key
     *
     * @return void
     */
    public function remove(string $key)
    {
        unset($this->parameters[$key]);
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function replace(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->parameters);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->parameters);
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->parameters;
    }

    /**
     * @param $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * @param $offset
     *
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param $offset
     * @param $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * @param $offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

}
