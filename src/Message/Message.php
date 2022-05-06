<?php

namespace Yng\Http\Message;

use Yng\Http\Message\Bags\HeaderBag;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @class   Message
 * @author  Yng
 * @date    2021/12/18
 * @time    12:40
 * @package Yng\Http\Message
 */
class Message implements MessageInterface
{
    /**
     * @var string
     */
    protected string $protocolVersion = '1.1';

    /**
     * @var HeaderBag
     */
    protected HeaderBag $headers;

    /**
     * @var StreamInterface|null
     */
    protected ?StreamInterface $body;

    /**
     * @return string
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /**
     * @param $version
     *
     * @return $this|Request|Response|ServerRequest
     */
    public function withProtocolVersion($version)
    {
        $new                  = clone $this;
        $new->protocolVersion = $version;

        return $new;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers->all();
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasHeader($name)
    {
        return $this->headers->has($name);
    }

    /**
     * @inheritDoc
     * @return arrray|string[]
     */
    public function getHeader($name)
    {
        return $this->headers->get($name, []);
    }

    /**
     * @param $name
     *
     * @return string
     */
    public function getHeaderLine($name)
    {
        if ($header = $this->getHeader($name)) {
            return implode(',', $header);
        }

        return '';
    }

    /**
     * TODO
     *
     * @param string          $name
     * @param string|string[] $value
     *
     * @return Message|void
     */
    public function withHeader($name, $value)
    {
        $new          = clone $this;
        $newHeaders   = clone $this->headers;
        $new->headers = $newHeaders;

        $newHeaders->set($name, $value);

        return $new;
    }

    /**
     * @param $name
     * @param $value
     *
     * @return mixed
     */
    public function withAddedHeader($name, $value)
    {
        $new = clone $this;

        $newHeaders = clone $this->headers;
        $newHeaders->addOne($name, $value);
        $new->headers = $newHeaders;

        return $new;
    }

    /**
     * @param $name
     *
     * @return Request|Response|ServerRequest
     */
    public function withoutHeader($name)
    {
        $new        = clone $this;
        $newHeaders = clone $this->headers;
        if ($newHeaders->has($name)) {
            $newHeaders->remove($name);
        }
        $new->headers = $newHeaders;

        return $new;
    }

    /**
     * @return StreamInterface|null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param StreamInterface $body
     *
     * @return $this|Request|Response|ServerRequest
     */
    public function withBody(StreamInterface $body)
    {
        $new       = clone $this;
        $new->body = $body;
        return $new;
    }

}
