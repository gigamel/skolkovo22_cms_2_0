<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Events;

use Closure;

interface ListenerInterface
{
    public function subscribeEvent(string $name, Closure $handler): void;
    
    public function triggerEvent(string $name, ...$args): void;
}
