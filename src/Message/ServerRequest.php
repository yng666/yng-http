<?php

namespace Yng\Http\Message;

use Yng\Http\Message\Bags\FileBag;
use Yng\Http\Message\Bags\InputBag;
use Yng\Http\Message\Bags\ParameterBag;
use Yng\Http\Message\Bags\ServerBag;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @class   ServerRequest
 * @author  Yng
 * @date    2021/12/18
 * @time    12:40
 * @package Yng\Http\Message
 */
class ServerRequest extends Request implements ServerRequestInterface
{
    /**
     * @var ServerBag
     */
    protected ServerBag $serverParams;

    /**
     * @var InputBag
     */
    protected InputBag $cookieParams;

    /**
     * @var InputBag
     */
    protected InputBag $queryParams;

    /**
     * @var ParameterBag
     */
    protected ParameterBag $attributes;

    /**
     * @var FileBag
     */
    protected FileBag $uploadedFiles;

    /**
     * @var InputBag
     */
    protected InputBag $parsedBody;

    /**
     * @return array
     */
    public function getServerParams()
    {
        return $this->serverParams->all();
    }

    /**
     * @return array
     */
    public function getCookieParams()
    {
        return $this->cookieParams->all();
    }

    /**
     * @param array $cookies
     *
     * @return ServerRequest
     */
    public function withCookieParams(array $cookies)
    {
        $new            = clone $this;
        $newCookieParam = clone $this->cookieParams;
        $newCookieParam->set($cookies);
        $new->cookieParams = $newCookieParam;

        return $new;
    }

    /**
     * @return array
     */
    public function getQueryParams()
    {
        return $this->queryParams->all();
    }

    /**
     * @param array $query
     *
     * @return ServerRequest
     */
    public function withQueryParams(array $query)
    {
        $new            = clone $this;
        $newQueryParams = clone $this->queryParams;
        $newQueryParams->set($query);
        $new->queryParams = $newQueryParams;

        return $new;
    }

    /**
     * @return array|FileBag
     */
    public function getUploadedFiles()
    {
        return $this->uploadedFiles->all();
    }

    /**
     * @param array $uploadedFiles
     *
     * @return ServerRequest
     */
    public function withUploadedFiles(array $uploadedFiles)
    {
        $new              = clone $this;
        $newUploadedFiles = clone $this->uploadedFiles;
        $newUploadedFiles->replace(array_merge($newUploadedFiles->all(), $uploadedFiles));
        $new->uploadedFiles = $newUploadedFiles;

        return $new;
    }

    /**
     * @return array|object|void|null
     */
    public function getParsedBody()
    {
        if (0 === strcasecmp('POST', $this->getMethod()) && $this->hasHeader('Content-Type')) {
            $contentType = $this->getHeaderLine('Content-Type');
            if (false !== stripos($contentType, 'application/x-www-form-urlencoded')
                || false !== stripos($contentType, 'multipart/form-data')
            ) {
                // TODO
                return $_POST;
            }
        }

        return $this->parsedBody->all();
    }

    /**
     * @param $data
     *
     * @return ServerRequest|void
     */
    public function withParsedBody($data)
    {
        $new             = clone $this;
        $new->parsedBody = $data;

        return $new;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes->all();
    }

    /**
     * @param $name
     * @param $default
     *
     * @return mixed|null
     */
    public function getAttribute($name, $default = null)
    {
        return $this->attributes->get($name, $default);
    }

    /**
     * @param $name
     * @param $value
     *
     * @return ServerRequest
     */
    public function withAttribute($name, $value)
    {
        $new          = clone $this;
        $newAttribute = clone $this->attributes;
        $newAttribute->set($name, $value);
        $new->attributes = $newAttribute;

        return $new;
    }

    /**
     * @param $name
     *
     * @return ServerRequest|string
     */
    public function withoutAttribute($name)
    {
        $new          = clone $this;
        $newAttribute = clone $this->attributes;
        $newAttribute->remove($name);
        $new->attributes = $newAttribute;

        return $name;
    }

}
