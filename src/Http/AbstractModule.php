<?php

declare(strict_types=1);

namespace Skolkovo22\Http;

use Skolkovo22\Http\AbstractApplication;

abstract class AbstractModule
{
    abstract public function boot(AbstractApplication $app): void;
}
