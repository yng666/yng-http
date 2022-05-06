<?php

namespace Yng\Http\Message;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * @class   Request
 * @author  Yng
 * @date    2021/12/18
 * @time    12:40
 * @package Yng\Http\Message
 */
class Request extends Message implements RequestInterface
{
    /**
     * @var UriInterface
     */
    protected UriInterface $uri;

    /**
     * @var string
     */
    protected string $method;

    /**
     * @var string
     */
    protected string $requestTarget = '/';

    /**
     * @return string
     */
    public function getRequestTarget()
    {
        if ('/' === $this->requestTarget) {
            return $this->uri->getPath() . $this->uri->getQuery();
        }
        return '/';
    }

    /**
     * @param $requestTarget
     *
     * @return Request
     */
    public function withRequestTarget($requestTarget)
    {
        $new               = clone $this;
        $new->requestTarget = $requestTarget;

        return $new;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param $method
     *
     * @return Request
     */
    public function withMethod($method)
    {
        $new         = clone $this;
        $new->method = $method;

        return $new;
    }

    /**
     * @return UriInterface
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param UriInterface $uri
     * @param              $preserveHost
     *
     * @return Request
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $new = clone $this;
        if (true === $preserveHost) {
            $uri = $uri->withHost($this->getHeaderLine('Host'));
        }
        $new->uri = $uri;

        return $new;
    }
}
