<?php

declare(strict_types=1);

namespace App\Common\Http;

use App\Application;

abstract class AbstractController
{
    public function __construct(protected Application $app)
    {
    }
}
