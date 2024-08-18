<?php

use App\Controller\DefaultController;

return [
    '/' => [
        '_controller' => DefaultController::class,
        '_action' => 'index',
        '_methods' => ['GET', 'POST'],
    ],
];
