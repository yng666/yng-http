<?php

namespace Yng\Http\Message;

use Psr\Http\Message\UriInterface;

/**
 * @class   Uri
 * @author  Yng
 * @date    2021/12/18
 * @time    12:39
 * @package Yng\Http\Message
 */
class Uri implements UriInterface
{
    /**
     * @var string
     */
    protected string $path = '/';

    /**
     * @var string
     */
    protected string $scheme = 'http';

    /**
     * @var string
     */
    protected string $host = 'localhost';

    /**
     * @var int
     */
    protected int $port = 80;

    /**
     * @var string
     */
    protected string $query = '';

    /**
     * @var string
     */
    protected string $fragment = '';

    /**
     * @var string
     */
    protected string $authority = '';

    /**
     * @var string|mixed
     */
    protected string $userinfo = '';

    /**
     * TODO
     *
     * @param string $uri
     */
    public function __construct(string $uri)
    {
        if (false === $parts = parse_url($uri)) {
            throw new \InvalidArgumentException("Unable to parse URI: {$uri}");
        }

        if (isset($parts['scheme'])) {
            $this->scheme = $parts['scheme'];
        }
        if (isset($parts['user'])) {
            $this->userinfo = isset($parts['pass']) ? sprintf('%s:%s', $parts['user'], $parts['pass']) : $parts['user'];
        }
        if (isset($parts['host'])) {
            $this->host = $parts['host'];
        }
        $this->port = isset($parts['port']) ? $parts['port'] : ['http' => 80, 'https' => 443][$this->scheme];
        if (isset($parts['path'])) {
            $this->path = '/' . trim($parts['path'], '/');
        }
        if (isset($parts['query'])) {
            $this->query = $parts['query'];
        }
        if (isset($parts['fragment'])) {
            $this->fragment = $parts['fragment'];
        }
        if ('' !== $this->userinfo) {
            $port            = ($this->port > 655535 || $this->port < 0) ? '' : $this->getPortString();
            $this->authority = $this->userinfo . '@' . $this->host . $port;
        }
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @return string|void
     */
    public function getAuthority()
    {
        return $this->authority;
    }

    /**
     * @return string|void
     */
    public function getUserInfo()
    {
        return $this->userinfo;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return int|null
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return string
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * @param $scheme
     *
     * @return Uri
     */
    public function withScheme($scheme)
    {
        $new         = clone $this;
        $new->scheme = $scheme;

        return $new;
    }

    /**
     * @param $user
     * @param $password
     *
     * @return Uri|void
     */
    public function withUserInfo($user, $password = null)
    {
        $new           = clone $this;
        $new->userinfo = sprintf('%s%s', $user, $password ? (':' . $password) : '');

        return $new;
    }

    /**
     * @param $host
     *
     * @return Uri
     */
    public function withHost($host)
    {
        $new       = clone $this;
        $new->host = $host;

        return $new;
    }

    /**
     * @param $port
     *
     * @return Uri
     */
    public function withPort($port)
    {
        $new       = clone $this;
        $new->port = $port;

        return $new;
    }

    /**
     * @param $path
     *
     * @return Uri
     */
    public function withPath($path)
    {
        $new       = clone $this;
        $new->path = $path;

        return $new;
    }

    /**
     * @param $query
     *
     * @return Uri
     */
    public function withQuery($query)
    {
        $new        = clone $this;
        $new->query = $query;

        return $new;
    }

    /**
     * @param $fragment
     *
     * @return Uri
     */
    public function withFragment($fragment)
    {
        $new           = clone $this;
        $new->fragment = $fragment;

        return $new;
    }

    /**
     * @return string
     */
    protected function getPortString()
    {
        if (('http' === $this->scheme && 80 === $this->port) ||
            ('https' === $this->scheme && 443 === $this->port)) {
            return '';
        }

        return ':' . $this->port;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s://%s%s%s%s%s',
            $this->getScheme(),
            $this->getHost(),
            $this->getPortString(),
            $this->getPath(),
            ('' === $this->query) ? '' : ('?' . $this->query),
            ('' === $this->fragment) ? '' : ('#' . $this->fragment),
        );
    }
}
