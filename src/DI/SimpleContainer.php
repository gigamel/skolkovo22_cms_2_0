<?php

declare(strict_types=1);

namespace Skolkovo22\DI;

use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
use Skolkovo22\Common\DI\ContainerInterface;
use Skolkovo22\Common\Loader\ArrayImporterInterface;
use Exception;

use function array_key_exists;
use function is_null;
use function is_object;
use function sprintf;

class SimpleContainer implements ContainerInterface
{
    protected array $_dependencies = [];

    protected array $_arguments = [];

    public function __construct(private readonly ArrayImporterInterface $importer)
    {
    }
    
    public function importArguments(string $file): void
    {
        $this->_arguments = array_replace_recursive(
            $this->_arguments,
            $this->importer->importArrayFrom($file)
        );
    }

    /**
     * @throws Exception
     */
    public function setDependency(string $interfaceOrClassName, string $className): void
    {
        if (array_key_exists($interfaceOrClassName, $this->_dependencies)) {
            throw new Exception(
                sprintf('Dependency [%s] already exists', $interfaceOrClassName)
            );
        }

        $this->_dependencies[$interfaceOrClassName] = $className;
    }

    /**
     * @throws Exception
     */
    public function getDependency(string $interfaceOrClassName): object
    {
        if (!array_key_exists($interfaceOrClassName, $this->_dependencies)) {
            throw new Exception(
                sprintf('Unknown dependency [%s]', $interfaceOrClassName)
            );
        }

        if (is_object($this->_dependencies[$interfaceOrClassName])) {
            return $this->_dependencies[$interfaceOrClassName];
        }
        
        $reflection = new ReflectionClass($this->_dependencies[$interfaceOrClassName]);

        $constructor = $reflection->getConstructor();
        if (is_null($constructor)) {
            $this->_dependencies[$interfaceOrClassName] = $reflection->newInstance();
        } else {
            $this->_dependencies[$interfaceOrClassName] = $reflection->newInstanceArgs(
                $this->parseArguments(
                    $interfaceOrClassName,
                    $constructor
                )
            );
        }

        unset($this->_arguments[$interfaceOrClassName]);
        return $this->_dependencies[$interfaceOrClassName];
    }
    
    protected function parseArguments(string $interfaceOrClassName, ReflectionMethod $reflectionMethod): array
    {
        $arguments = [];

        foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
            $arguments[$reflectionParameter->getName()] = $this->resolveArgument(
                $interfaceOrClassName,
                $reflectionParameter
            );
        }

        return $arguments;
    }
    
    protected function resolveArgument(string $interfaceOrClassName, ReflectionParameter $reflectionParameter): mixed
    {
        $argument = $this->_arguments[$interfaceOrClassName][$reflectionParameter->getName()] ?? null;
        if (is_null($argument) && $reflectionParameter->isDefaultValueAvailable()) {
            return $reflectionParameter->getDefaultValue();
        }
        
        if ($reflectionParameter->hasType()) {
            $type = $reflectionParameter->getType()->getName();
            if (class_exists($type) || interface_exists($type)) {
                return $this->getDependency($type);
            }
        }

        return $argument;
    }
}
