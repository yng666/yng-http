<?php

namespace Yng\Http\Server;

use Closure;
use Yng\Di\Container;
use Yng\Http\Exceptions\InvalidRequestHandlerException;
use OutOfBoundsException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SeekableIterator;

/**
 * @class   RequestHandler
 * @author  Yng
 * @date    2021/12/26
 * @time    10:30
 * @package Yng\Framework
 */
class RequestHandler implements RequestHandlerInterface, SeekableIterator
{
    /**
     * @var int
     */
    protected int $offset = 0;

    /**
     * @var array[]|string[]|MiddlewareInterface[]
     */
    protected array $middlewares = [];

    /**
     * @var Closure|RequestHandlerInterface
     */
    protected $requestHandler = null;

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var MiddlewareInterface $middleware */
        if (!$this->valid()) {
            return $this->handleRequest($request);
        }
        $middleware = $this->current();
        $this->next();

        return $this->handleMiddleware($middleware, $request);
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    protected function handleRequest(ServerRequestInterface $request): ResponseInterface
    {
        switch (true) {
            case $this->requestHandler instanceof Closure :
                return ($this->requestHandler)($request);
            case $this->requestHandler instanceof RequestHandlerInterface :
                return $this->requestHandler->handle($request);
        }
        throw new InvalidRequestHandlerException('The RequestHandler must be a closure or object that implements the RequestHandlerInterface.');
    }

    /**
     * @param array[]|string|object  $middleware
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    protected function handleMiddleware($middleware, ServerRequestInterface $request): ResponseInterface
    {
        $addition = [];
        if (\is_array($middleware)) {
            [$middleware, $addition] = $middleware;
        }

        $addition = is_array($addition) ? $addition : [$addition];

        if ($middleware instanceof Closure) {
            return $middleware($request, $this, ...$addition);
        }

        if (\is_string($middleware)) {
            if (\class_exists('Yng\Di\Container')) {
                $middleware = Container::getInstance()->make($middleware, $addition);
            } else {
                $middleware = new $middleware(...$addition);
            }
        }

        if (is_object($middleware) && $middleware instanceof MiddlewareInterface) {
            return $middleware->process($request, $this);
        }

        throw new InvalidRequestHandlerException('The middleware must be an array, string, or object that implements the MiddlewareInterface.');
    }

    /**
     * @return array|mixed|MiddlewareInterface|string
     */
    public function current()
    {
        return $this->middlewares[$this->offset];
    }

    /**
     * @return void
     */
    public function next()
    {
        ++$this->offset;
    }

    /**
     * @return bool|float|int|mixed|string|null
     */
    public function key()
    {
        return $this->offset;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->middlewares[$this->offset]);
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->offset = 0;
    }

    /**
     * @param $offset
     *
     * @return void
     */
    public function seek($offset)
    {
        if (!isset($this->middlewares[$offset])) {
            throw new OutOfBoundsException("Invalid seek offset ($offset)");
        }

        $this->offset = $offset;
    }

    /**
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * @param $middleware
     *
     * @return void
     */
    public function push($middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @return array|MiddlewareInterface|string|null
     */
    public function pop()
    {
        return array_pop($this->middlewares);
    }

    /**
     * @return array|MiddlewareInterface|string|null
     */
    public function shift()
    {
        return array_shift($this->middlewares);
    }

    /**
     * @param $middlewares
     *
     * @return int
     */
    public function unshift($middlewares)
    {
        $middlewares = is_array($middlewares) ? $middlewares : func_get_args();

        return array_unshift($this->middlewares, ...$middlewares);
    }

    /**
     * @param array $middlewares 设置中间件
     *
     * @return $this
     */
    public function setMiddlewares(array $middlewares)
    {
        $this->middlewares = $middlewares;

        return $this;
    }

    /**
     * @return Closure|RequestHandlerInterface
     */
    public function getRequestHandler()
    {
        return $this->requestHandler;
    }

    /**
     * @param Closure|RequestHandlerInterface $requestHandler
     *
     * @return $this
     */
    public function setRequestHandler($requestHandler)
    {
        $this->requestHandler = $requestHandler;

        return $this;
    }
}
