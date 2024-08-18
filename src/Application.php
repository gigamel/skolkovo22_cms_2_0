<?php

declare(strict_types=1);

namespace App;

use App\Common\DI\ContainerInterface;
use App\Common\Loader\ArrayImporterInterface;
use App\Common\Loader\ConfigLoader;
use App\Common\Loader\ConfigLoaderInterface;
use App\Common\Loader\PHPFileArrayImporter;
use App\DI\SimpleContainer;
use App\Common\Events\ListenerInterface;
use App\Common\Events\EventsListener;
use App\Util\Dumper;
use Closure;
use Throwable;

final class Application
{
    private float $startTime;

    private int $startMemoryUsage;

    private bool $isRunning = false;

    private ContainerInterface $container;

    private ListenerInterface $listener;

    private ConfigLoaderInterface $configLoader;

    /**
     * @param ContainerInterface|null $container
     * @param ListenerInterface|null $listener
     * @param ConfigLoaderInterface|null $configLoader
     */
    public function __construct(
        ?ContainerInterface $container = null,
        ?ListenerInterface $listener = null,
        ?ConfigLoaderInterface $configLoader = null
    ) {
        $this->startTime = microtime(true);
        $this->startMemoryUsage = memory_get_usage();

        $this->container = $container ?? new SimpleContainer(new PHPFileArrayImporter());
        $this->listener = $listener ?? new EventsListener();

        $this->configLoader = $configLoader ?? new ConfigLoader(
            new PHPFileArrayImporter()
        );
    }

    /**
     * @return void
     */
    public function run(): void
    {
        if ($this->isRunning) {
            return;
        }

        $this->isRunning = true;

        try {
            $this->runProcess();
        } catch (Throwable $e) {
            Dumper::dump($e);
        }
    }

    /**
     * @param string $option
     * @param mixed $default
     *
     * @return mixed
     */
    public function getConfig(string $option, mixed $default = null): mixed
    {
        return $this->configLoader->getConfig($option, $default);
    }

    /**
     * @param string $file
     *
     * @return void
     */
    public function importConfigurationFrom(string $file): void
    {
        $this->configLoader->importFrom($file);
    }

    /**
     * @param string $interfaceOrClassName
     * @param string $className
     *
     * @return void
     *
     * @throws Exception
     */
    public function setDependency(string $interfaceOrClassName, string $className): void
    {
        $this->container->setDependency($interfaceOrClassName, $className);
    }

    /**
     * @param string $interfaceOrClassName
     *
     * @return object
     *
     * @throws Exception
     */
    public function getDependency(string $interfaceOrClassName): object
    {
        return $this->container->getDependency($interfaceOrClassName);
    }

    /**
     * @param string $file
     *
     * @return void
     */
    public function importContainerArguments(string $file): void
    {
        $this->container->importArguments($file);
    }

    /**
     * @param string $name
     * @param Closure $handler
     *
     * @return void
     */
    public function subscribeEvent(string $name, Closure $handler): void
    {
        $this->listener->subscribeEvent($name, $handler);
    }

    /**
     * @param string $name
     * @param $args
     *
     * @return void
     */
    public function triggerEvent(string $name, ...$args): void
    {
        $this->listener->triggerEvent($name, ...$args);
    }

    /**
     * @return float
     */
    public function getExecutionTime(): float
    {
        return microtime(true) - $this->startTime;
    }

    /**
     * @return int
     */
    public function getMemoryusage(): int
    {
        return memory_get_usage() - $this->startMemoryUsage;
    }

    /**
     * @return void
     *
     * @throws Throwable
     */
    private function runProcess(): void
    {
        $this->importConfigurationFrom(__DIR__ . '/../config/base.php');
        $this->setupCommonDependencies();
    }

    /**
     * @return void
     */
    private function setupCommonDependencies(): void
    {
        $this->importContainerArguments(__DIR__ . '/../config/services.php');

        $dependecies = require_once(__DIR__ . '/../config/di.php');
        foreach ($dependecies as $dependency => $service) {
            $this->setDependency($dependency, $service);
        }
    }
}
