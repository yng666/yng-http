<?php

namespace Yng\Http\Message;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

class StreamFactory implements StreamFactoryInterface
{
    public function createStreamFromResource($resource): StreamInterface
    {
        // TODO: Implement createStreamFromResource() method.
    }

    public function createStream(string $content = ''): StreamInterface
    {
        // TODO: Implement createStream() method.
    }

    public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        // TODO: Implement createStreamFromFile() method.
    }
}
