<?php

declare(strict_types=1);

namespace Skolkovo22\Application;

use Exception;
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

    protected ContainerInterface $container;

    protected ArrayImporterInterface $arrayImporter;

    protected ListenerInterface $listener;

    protected ConfigLoaderInterface $configLoader;
    
    public function __construct(
        ?ContainerInterface $container = null,
        ?ListenerInterface $listener = null,
        ?ConfigLoaderInterface $configLoader = null
    ) {
        $this->startTime = microtime(true);
        $this->arrayImporter = new PHPFileArrayImporter();
        $this->container = $container ?? new SimpleContainer($this->arrayImporter);
        $this->listener = $listener ?? new EventsListener();
        $this->configLoader = $configLoader ?? new ConfigLoader($this->arrayImporter);
    }
    
    abstract public function run(): void;
    
    public function getConfig(string $option, mixed $default = null): mixed
    {
        return $this->configLoader->getConfig($option, $default);
    }
    
    public function importConfigurationFrom(string $file): void
    {
        $this->configLoader->importFrom($file);
    }

    /**
     * @throws Exception
     */
    public function setDependency(string $interfaceOrClassName, string $className): void
    {
        $this->container->setDependency($interfaceOrClassName, $className);
    }

    /**
     * @throws Exception
     */
    public function getDependency(string $interfaceOrClassName): object
    {
        return $this->container->getDependency($interfaceOrClassName);
    }
    
    public function importContainerArguments(string $file): void
    {
        $this->container->importArguments($file);
    }
    
    public function subscribeEvent(string $name, Closure $handler): void
    {
        $this->listener->subscribeEvent($name, $handler);
    }
    
    public function triggerEvent(string $name, ...$args): void
    {
        $this->listener->triggerEvent($name, ...$args);
    }
    
    final public function getExecutionTime(): float
    {
        return microtime(true) - $this->startTime;
    }
    
    final public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
    
    final public function getListener(): ListenerInterface
    {
        return $this->listener;
    }
}
