<?php

declare(strict_types=1);

namespace Skolkovo22\Module\Main;

use Skolkovo22\Common\Http\RouterInterface;
use Skolkovo22\Http\AbstractApplication;
use Skolkovo22\Http\AbstractModule;
use Skolkovo22\Module\Main\Controller\AdminController;
use Skolkovo22\Module\Main\Controller\PageController;

final class Module extends AbstractModule
{
    public function boot(AbstractApplication $app): void
    {
        $app->getDependency(RouterInterface::class)->route('main.pages', '/', PageController::class, 'index');
        $app->getDependency(RouterInterface::class)->route('admin.main.pages', '/admin/', AdminController::class, 'index');
        
        $app->subscribeEvent('route.found', static function (\Skolkovo22\Common\Http\RouteInterface $route): bool {
            return true;
        });
        
        $app->subscribeEvent('route.notfound', static function (\Exception $e): bool {
            return true;
        });
    }
}
