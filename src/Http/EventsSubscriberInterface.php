<?php

declare(strict_types=1);

namespace Skolkovo22\Http;

use Skolkovo22\Common\Events\ListenerInterface;

interface EventsSubscriberInterface
{
    public function subscribeEvents(ListenerInterface $listener): void;
}
