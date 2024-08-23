<?php

declare(strict_types=1);

namespace Skolkovo22\Application;

use Exception;
use Skolkovo22\Http\AbstractApplication;
use Skolkovo22\Http\AbstractModule;
use Throwable;

use function error_reporting;
use function ini_set;

class ExampleApplication extends AbstractApplication
{
    private const string ENV_DEV = 'dev';
    
    private bool $isRunning = false;
    
    public function run(): void
    {
        if ($this->isRunning) {
            return;
        }

        $this->isRunning = true;

        try {
            $this->runApplication();
        } catch (Throwable $e) {
            if ($this->envIsDev()) {
                $this->dump($e);
                return;
            }
            
            $this->dump('Page Not Found');
        }
    }
    
    public function envIsDev(): bool
    {
        return self::ENV_DEV === $this->getConfig('env');
    }

    /**
     * @throws Throwable
     */
    private function runApplication(): void
    {
        $this->setupAliases();
        $this->importConfigurations();
        $this->setupCommonDependencies();
        $this->bootModules();
        $this->routerProcess();
    }
    
    private function setupAliases(): void
    {
        self::setAlias('@config', __DIR__ . '/../../config');
    }
    
    private function importConfigurations(): void
    {
        $this->importConfigurationFrom(self::getAlias('@config/base.php'));
        $this->importConfigurationFrom(self::getAlias('@config/local.php'));
    }
    
    /**
     * @throws Exception
     */
    private function setupCommonDependencies(): void
    {
        $this->importContainerArguments(self::getAlias('@config/di.php'));

        foreach (
            $this->arrayImporter->importArrayFrom(
                self::getAlias('@config/services.php')
            ) as $dependency => $service
        ) {
            $this->setDependency($dependency, $service);
        }
    }
    
    /**
     * @throws Exception
     */
    private function bootModules(): void
    {
        foreach (
            $this->arrayImporter->importArrayFrom(
                self::getAlias('@config/modules.php')
            ) as $moduleClass
        ) {
            if (is_a($moduleClass, AbstractModule::class, true)) {
                (new $moduleClass())->boot($this);
                continue;
            }
            
            if ($this->envIsDev()) {
                throw new Exception(
                    sprintf(
                        'Module [%s] should be intanceof [%s]',
                        $moduleClass,
                        AbstractModule::class
                    )
                );
            }
        }
    }
    
    private function routerProcess(): void
    {
        try {
            $route = $this->getDependency(\Skolkovo22\Common\Http\RouterInterface::class)->handle(new \Skolkovo22\Common\Http\Request());
            $this->onRouteFound($route);
        } catch (Exception $e) {
            $this->triggerEvent('route.notfound', $e);
            throw $e;
        }
    }
    
    private function onRouteFound(\Skolkovo22\Common\Http\RouteInterface $route): void
    {
        $this->triggerEvent('route.found', $route);
        
        $controllerClass = $route->getController();
        $controller = new $controllerClass();
        $response = $controller->{$route->getAction()}(new \Skolkovo22\Common\Http\Request());
        $response->send();
        
        echo $response->getBody();
        die();
    }
}
