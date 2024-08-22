<?php

use Skolkovo22\Application\ExampleApplication;

require_once __DIR__ . '/../autoload.php';

if ('cli' === PHP_SAPI) {
    exit(1);
}

(new ExampleApplication())->run();
