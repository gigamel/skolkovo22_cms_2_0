<?php

use Skolkovo22\Application\Blog\Application;

require_once __DIR__ . '/../autoload.php';

if ('cli' === PHP_SAPI) {
    exit(1);
}

ini_set('display_errors', true);
error_reporting(E_ALL);

(new Application())->run();
