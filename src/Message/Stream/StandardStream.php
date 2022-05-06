<?php

namespace Yng\Http\Message\Stream;

use Psr\Http\Message\StreamInterface;

class StandardStream implements StreamInterface
{

    protected $stream;

    public function __construct($stream)
    {
        if (\is_string($stream)) {
            $this->stream = \fopen('php://temp', 'rw+');
            \fwrite($this->stream, $stream);
        } else if (is_resource($stream)) {
            $this->stream = $stream;
        } else {
            throw new \InvalidArgumentException('Message must be a stream or resource.');
        }
    }


    public function __toString()
    {
        // TODO: Implement __toString() method.
    }

    public function close()
    {
        // TODO: Implement close() method.
    }

    public function detach()
    {
        // TODO: Implement detach() method.
    }

    public function getSize()
    {
        // TODO: Implement getSize() method.
    }

    public function tell()
    {
        // TODO: Implement tell() method.
    }

    public function eof()
    {
        return !isset($this->stream) || \feof($this->stream);
    }

    public function isSeekable()
    {
        // TODO: Implement isSeekable() method.
    }

    public function seek($offset, $whence = SEEK_SET)
    {
        // TODO: Implement seek() method.
    }

    public function rewind()
    {
        // TODO: Implement rewind() method.
    }

    public function isWritable()
    {
        // TODO: Implement isWritable() method.
    }

    public function write($string)
    {
        // TODO: Implement write() method.
    }

    public function isReadable()
    {
        // TODO: Implement isReadable() method.
    }

    public function read($length)
    {
        // TODO: Implement read() method.
    }

    public function getContents()
    {
        // TODO: Implement getContents() method.
    }

    public function getMetadata($key = null)
    {
        // TODO: Implement getMetadata() method.
    }
}
