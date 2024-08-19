<?php

use Skolkovo22\Application\WebApplication;
use Skolkovo22\Util\Dumper;

require_once __DIR__ . '/../autoload.php';

if ('cli' === PHP_SAPI) {
    exit(1);
}

ini_set('display_errors', true);
error_reporting(E_ALL);

$application = (new WebApplication())->build();

Dumper::dump('Welcome to CMS 2.0!');
