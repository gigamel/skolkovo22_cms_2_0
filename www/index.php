<?php

use Skolkovo22\Application\WebApplication;

require_once __DIR__ . '/../autoload.php';

if ('cli' === PHP_SAPI) {
    exit(1);
}

ini_set('display_errors', true);
error_reporting(E_ALL);

(new WebApplication())->run();
