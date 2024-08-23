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
                var_dump($e);
            }
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
        
        $this->triggerEvent('modules.loaded', $this);
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
    
    private function setupCommonDependencies(): void
    {
        $this->importContainerArguments(self::getAlias('@config/services.php'));

        foreach (
            $this->arrayImporter->importArrayFrom(
                self::getAlias('@config/di.php')
            ) as $dependency => $service
        ) {
            $this->setDependency($dependency, $service);
        }
    }
    
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
}
