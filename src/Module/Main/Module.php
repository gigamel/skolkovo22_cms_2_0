<?php

declare(strict_types=1);

namespace Skolkovo22\Module\Main;

use Skolkovo22\Common\Events\ListenerInterface;
use Skolkovo22\Http\AbstractModule;
use Skolkovo22\Http\EventsSubscriberInterface;

final class Module extends AbstractModule implements EventsSubscriberInterface
{
    public function subscribeEvents(ListenerInterface $listener): void
    {
        $listener->subscribeEvent('main.request', static function (\Skolkovo22\Http\AbstractApplication $app): bool {
            var_dump($app->getConfig('env'));
            return true;
        });
    }
}
