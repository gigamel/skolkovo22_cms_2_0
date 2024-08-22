<?php

use Skolkovo22\Application\Blog\Application;

require_once __DIR__ . '/../autoload.php';

if ('cli' === PHP_SAPI) {
    exit(1);
}

(new Application())->run();
