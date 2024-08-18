<?php

declare(strict_types=1);

namespace App\Controller;

use App\Common\Http\AbstractController;

final class DefaultController extends AbstractController
{
    public function index()
    {
        $this->app->setDependency(TestController::class, new TestController($this->app));
    }
}
