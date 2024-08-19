<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Http;

use Skolkovo22\Application;

abstract class AbstractController
{
    public function __construct(protected Application $app)
    {
    }
}
