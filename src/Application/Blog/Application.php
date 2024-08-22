<?php

declare(strict_types=1);

namespace Skolkovo22\Application\Blog;

use Skolkovo22\Application\AbstractApplication;
use Throwable;

use function error_reporting;
use function ini_set;

class Application extends AbstractApplication
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
        $this->configurationProcess();
        $this->setupCommonDependencies();
    }
    
    private function setupCommonDependencies(): void
    {
        $this->importContainerArguments(__DIR__ . '/../../../config/services.php');

        foreach (
            $this->arrayImporter->importArrayFrom(__DIR__ . '/../../../config/di.php')
            as $dependency => $service
        ) {
            $this->setDependency($dependency, $service);
        }
    }
    
    private function configurationProcess(): void
    {
        $this->importConfigurationFrom(__DIR__ . '/../../../config/base.php');
        $this->importConfigurationFrom(__DIR__ . '/../../../config/local.php');
        
        if ($this->envIsDev()) {
            ini_set('display_errors', true);
            error_reporting(E_ALL);
        }
    }
}
