<?php

declare(strict_types=1);

namespace Skolkovo22\Service\Log;

use Skolkovo22\Common\Log\LoggerInterface;
use Skolkovo22\Common\Stream\StreamInterface;

final class Logger implements LoggerInterface
{
    public function __construct(private StreamInterface $stream)
    {
    }
    
    public function info(string $message): void
    {
        $this->stream->write($message . PHP_EOL);
    }
}
