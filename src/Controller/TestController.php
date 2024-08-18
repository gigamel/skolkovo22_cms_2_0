<?php

declare(strict_types=1);

namespace App\Controller;

use App\Common\Http\AbstractController;

final class TestController extends AbstractController
{
    public function index()
    {
        echo 'Hello';
    }
}
