<?php

namespace Yng\Http\Message\Bags;

use Yng\Http\Message\UploadedFile;

/**
 * @class   FileBag
 * @author  Yng
 * @date    2022/04/23
 * @time    17:38
 * @package Yng\Http\Message\Bags
 */
class FileBag extends ParameterBag
{
    /**
     * @param string $key
     * @param        $default
     *
     * @return UploadedFile|mixed|null
     */
    public function get(string $key, $default = null)
    {
        return isset($this->parameters[$key]) ? new UploadedFile($this->parameters[$key]) : $default;
    }

    /**
     * 这个不正确，要重写 TODO
     *
     * @return array
     */
    public function all()
    {
        $parameter = [];
        foreach ($this->parameters as $key => $file) {
            $parameter[$key] = new UploadedFile($file);
        }
        return $parameter;
    }
}
