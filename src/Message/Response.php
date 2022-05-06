<?php

namespace Yng\Http\Message;

use Psr\Http\Message\ResponseInterface;

/**
 * @class   Response
 * @author  Yng
 * @date    2021/12/18
 * @time    12:40
 * @package Yng\Http\Message
 */
class Response extends Message implements ResponseInterface
{
    /**
     * 状态码
     *
     * @var int
     */
    protected int $status = 200;

    /**
     * Reason phases
     */
    protected const PHRASES = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-status',
        208 => 'Already Reported',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Requested range not satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        511 => 'Network Authentication Required',
    ];

    /**
     * @var string
     */
    protected string $reasonPhrase = '';

    /**
     * Http状态码取得
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->status;
    }

    /**
     * 设置状态码
     *
     * @param int    $code
     * @param string $reasonPhrase
     *
     * @return $this
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        $new               = clone $this;
        $new->status       = $code;
        $new->reasonPhrase = $reasonPhrase;
        return $new;
    }

    /**
     * @return mixed|string
     */
    public function getReasonPhrase()
    {
        if ('' === $this->reasonPhrase) {
            return static::PHRASES[$this->getStatusCode()] ?? '';
        }
        return '';
    }
}
