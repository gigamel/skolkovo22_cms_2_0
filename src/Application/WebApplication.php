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
    public function build(): AbstractApplication
    {
        if ($this->isRunning) {
            return $this;
        }

        $this->isRunning = true;

        try {
            $this->buildApplication();
        } catch (Throwable $e) {
            Dumper::dump($e);
        }

        return $this;
    }

    /**
     * @return void
     *
     * @throws Throwable
     */
    private function buildApplication(): void
    {
        $this->importConfigurationFrom(__DIR__ . '/../../config/base.php');
        $this->setupCommonDependencies();
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
