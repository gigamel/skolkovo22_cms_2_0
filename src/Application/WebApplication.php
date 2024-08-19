<?php

declare(strict_types=1);

namespace Skolkovo22\Application;

use Skolkovo22\Util\Dumper;
use Throwable;

class WebApplication extends AbstractApplication
{
    private bool $isRunning = false;

    /**
     * @return AbstractApplication
     */
    public function run(): void
    {
        if ($this->isRunning) {
            return;
        }

        $this->isRunning = true;
        
        $this->importConfigurationFrom(__DIR__ . '/../../config/base.php');
        $this->importConfigurationFrom(__DIR__ . '/../../config/local.php');

        try {
            $this->runApplication();
        } catch (Throwable $e) {
            'dev' === $this->getConfig('env')
                ? Dumper::dump($e)
                : Dumper::dump('Prodaction exception handler');
        }
    }

    /**
     * @return void
     *
     * @throws Throwable
     */
    private function runApplication(): void
    {
        $this->setupCommonDependencies();
        
        
        $reflection = new \ReflectionClass(\Skolkovo22\Controller\DefaultController::class);

        $constructor = $reflection->getConstructor();
        if (!$constructor) {
            $controller = $reflection->newInstance();
        } else {
            $args = [];
            foreach ($constructor->getParameters() as $parameter) {
                $args[] = $this->getDependency($parameter->getType()->getName());
            }

            $controller = $reflection->newInstanceArgs($args);
        }

        $response = $controller->index(new \Skolkovo22\Common\Http\Request());
        $response->send();

        Dumper::dump($response->getBody());
        exit;
    }

    /**
     * @return void
     */
    private function setupCommonDependencies(): void
    {
        $this->importContainerArguments(__DIR__ . '/../../config/services.php');

        foreach (
            $this->arrayImporter->importArrayFrom(__DIR__ . '/../../config/di.php')
            as $dependency => $service
        ) {
            $this->setDependency($dependency, $service);
        }
    }
}
