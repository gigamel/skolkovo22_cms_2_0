<?php

use Skolkovo22\Common\Http\RouterInterface;
use Skolkovo22\Common\Http\SimpleRouter;
use Skolkovo22\Common\Stream\FileStream;
use Skolkovo22\Common\Log\LoggerInterface;
use Skolkovo22\Common\Stream\StreamInterface;
use Skolkovo22\Service\Log\Logger;

return [
    RouterInterface::class => SimpleRouter::class,
    StreamInterface::class => FileStream::class,
    LoggerInterface::class => Logger::class,
];
