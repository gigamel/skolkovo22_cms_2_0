<?php

declare(strict_types=1);

namespace App\Service\Log;

use App\Common\Logger\LoggerInterface;
use App\Common\Stream\StreamInterface;

final class Logger implements LoggerInterface
{
    public function __construct(private StreamInterface $stream)
    {
    }

    /**
     * @param string $message
     *
     * @return void
     */
    public function info(string $message): void
    {
        $this->stream->write($message . PHP_EOL);
    }
}
