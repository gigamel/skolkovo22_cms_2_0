<?php

declare(strict_types=1);

namespace Skolkovo22\Module\Authentification;

use Skolkovo22\Common\Http\RouterInterface;
use Skolkovo22\Http\AbstractApplication;
use Skolkovo22\Http\AbstractModule;
use Skolkovo22\Module\Authentification\Controller\LoginController;
use Skolkovo22\Module\Authentification\Controller\LogoutController;

final class Module extends AbstractModule
{
    public function boot(AbstractApplication $app): void
    {
        $app->getDependency(RouterInterface::class)->route('login.page', '/login/', LoginController::class, 'index');
        $app->getDependency(RouterInterface::class)->route('logout.page', '/logout/', LogoutController::class, 'index');
        
        $app->subscribeEvent('route.found', static function (\Skolkovo22\Common\Http\RouteInterface $route) use ($app): bool {
            if (is_a($route->getController(), \Skolkovo22\Http\AbstractSecureController::class, true)) {
                $app->dump('Need authorization');
            }
            
            return true;
        });
    }
}
