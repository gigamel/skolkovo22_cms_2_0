<?php

declare(strict_types=1);

namespace Skolkovo22\Controller;

use Skolkovo22\Common\Http\AbstractController;

final class TestController extends AbstractController
{
    public function index()
    {
        echo 'Hello';
    }
}
