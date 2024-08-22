<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Events;

use Closure;

class EventsListener implements ListenerInterface
{
    protected array $_events = [];
    
    public function subscribeEvent(string $name, Closure $handler): void
    {
        $this->_events[$name][] = $handler;
    }
    
    public function triggerEvent(string $name, ...$args): void
    {
        foreach ($this->_events[$name] ?? [] as $handler) {
            if (!$handler(...$args)) {
                break;
            }
        }

        unset($this->_events[$name]);
    }
}
