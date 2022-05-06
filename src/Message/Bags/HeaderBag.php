<?php

namespace Yng\Http\Message\Bags;

/**
 * @class   HeaderBag
 * @author  Yng
 * @date    2022/04/23
 * @time    17:38
 * @package Yng\Http\Message\Bags
 */
class HeaderBag extends ParameterBag
{
    /**
     * @var array
     */
    protected array $keysMap = [];

    /**
     * @param $key
     * @param $value
     *
     * @return void
     */
    public function addOne($key, $value)
    {
        $uppercaseKey = \strtoupper($key);
        $value        = $this->formatValue($value);
        if ($this->has($key)) {
            array_push($this->parameters[$this->keysMap[$uppercaseKey]], ...$value);
        } else {
            $this->keysMap[$uppercaseKey] = $key;
            $this->parameters[$key]       = $value;
        }
    }

    /**
     * @param string $key
     * @param        $value
     *
     * @return void
     */
    public function set(string $key, $value)
    {
        $uppercaseKey = \strtoupper($key);
        if (isset($this->keysMap[$uppercaseKey])) {
            $key = $this->keysMap[$uppercaseKey];
        } else {
            $this->keysMap[$uppercaseKey] = $key;
        }
        $this->parameters[$key] = $this->formatValue($value);
    }

    /**
     * @param $value
     *
     * @return string[]
     */
    protected function formatValue($value)
    {
        if (is_scalar($value)) {
            $value = [(string)$value];
        }
        if (!is_array($value)) {
            throw new \InvalidArgumentException('The given header cannot be set.');
        }

        return array_values($value);
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    protected function getName($key)
    {
        return $this->keysMap[\strtoupper($key)];
    }

    /**
     * @param string $key
     *
     * @return void
     */
    public function remove(string $key)
    {
        if ($this->has($key)) {
            $uppercaseKey = \strtoupper($key);
            unset($this->parameters[$this->keysMap[$uppercaseKey]]);
            unset($this->keysMap[$uppercaseKey]);
        }
    }

    /**
     * @param string $key
     * @param        $default
     *
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        if ($this->has($key)) {
            return $this->parameters[$this->getName($key)];
        }
        return $default;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key)
    {
        return isset($this->keysMap[\strtoupper($key)]);
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function replace(array $parameters = [])
    {
        foreach ($parameters as $key => $value) {
            $this->keysMap[\strtoupper($key)] = $key;
            $this->parameters[$key]           = \is_array($value) ? $value : [$value];
        }
    }

}
