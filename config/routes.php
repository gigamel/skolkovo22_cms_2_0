<?php

use Skolkovo22\Controller\DefaultController;

return [
    '/' => [
        '_controller' => DefaultController::class,
        '_action' => 'index',
        '_methods' => ['GET', 'POST'],
    ],
];
