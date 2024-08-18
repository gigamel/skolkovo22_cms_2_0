<?php

use App\Application;
use App\Util\Dumper;

require_once __DIR__ . '/src/autoload.php';

if ('cli' === PHP_SAPI) {
    exit(1);
}

ini_set('display_errors', true);
error_reporting(E_ALL);

$application = new Application();
$application->run();

$application->subscribeEvent(
    'route.found',
    static function (string $controllerClass): bool {
        Dumper::dump($controllerClass);
        return true;
    }
);

$uriPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$routes = require_once(__DIR__ . '/config/routes.php');
foreach ($routes as $path => $config) {
    if ($uriPath !== $path) {
        continue;
    }

    if (!in_array($_SERVER['REQUEST_METHOD'], $config['_methods'])) {
        continue;
    }

    $route = $config;
    break;
}

if (isset($route)) {
    $application->triggerEvent('route.found', $route['_controller']);
}
