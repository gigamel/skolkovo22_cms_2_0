<?php

use App\Common\Logger\LoggerInterface;
use App\Common\Stream\FileStream;

return [
    LoggerInterface::class => [
        'stream' => new FileStream(__DIR__ . '/../var/log/info.log', 'a'),
    ],
];
