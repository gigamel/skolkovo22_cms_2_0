<?php

declare(strict_types=1);

namespace App\Common\Events;

use Closure;

interface ListenerInterface
{
    /**
     * @param string $name
     * @param Closure $handler
     *
     * @return void
     */
    public function subscribeEvent(string $name, Closure $handler): void;

    /**
     * @param string $name
     * @param $args
     *
     * @return void
     */
    public function triggerEvent(string $name, ...$args): void;
}
