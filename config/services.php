<?php

use Skolkovo22\Common\Log\LoggerInterface;
use Skolkovo22\Common\Stream\FileStream;

return [
    // tmp example
    LoggerInterface::class => [
        'stream' => new FileStream(__DIR__ . '/../var/log/info.log', 'a'),
    ],
];
