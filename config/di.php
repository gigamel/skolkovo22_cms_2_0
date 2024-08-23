<?php

use Skolkovo22\Common\Stream\StreamInterface;
use Skolkovo22\Common\Http\RoutesCollectionInterface;

return [
    StreamInterface::class => [
        'file' => __DIR__ . '/../var/log/info.log',
    ],
];
