<?php

declare(strict_types=1);

namespace Skolkovo22\Controller;

use Skolkovo22\Common\Http\AbstractController;

final class DefaultController extends AbstractController
{
    public function index()
    {
        $this->app->setDependency(TestController::class, new TestController($this->app));
    }
}
