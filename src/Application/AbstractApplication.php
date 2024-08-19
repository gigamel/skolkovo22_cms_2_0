<?php

declare(strict_types=1);

namespace Skolkovo22\Application;

use Skolkovo22\Common\DI\ContainerInterface;
use Skolkovo22\Common\Loader\ArrayImporterInterface;
use Skolkovo22\Common\Loader\ConfigLoader;
use Skolkovo22\Common\Loader\ConfigLoaderInterface;
use Skolkovo22\Common\Loader\PHPFileArrayImporter;
use Skolkovo22\DI\SimpleContainer;
use Skolkovo22\Common\Events\ListenerInterface;
use Skolkovo22\Common\Events\EventsListener;
use Closure;

abstract class AbstractApplication
{
    protected readonly float $startTime;

    protected readonly int $startMemoryUsage;

    protected ContainerInterface $container;

    protected ArrayImporterInterface $arrayImporter;

    protected ListenerInterface $listener;

    protected ConfigLoaderInterface $configLoader;

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

        $this->arrayImporter = new PHPFileArrayImporter();
        $this->container = $container ?? new SimpleContainer($this->arrayImporter);
        $this->listener = $listener ?? new EventsListener();
        $this->configLoader = $configLoader ?? new ConfigLoader($this->arrayImporter);
    }

    /**
     * @return void
     */
    abstract public function run(): void;

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
    final public function getExecutionTime(): float
    {
        return microtime(true) - $this->startTime;
    }

    /**
     * @return int
     */
    final public function getMemoryusage(): int
    {
        return memory_get_usage() - $this->startMemoryUsage;
    }
}
