<?php

declare(strict_types=1);

namespace Skolkovo22\DI;

use Skolkovo22\Common\DI\ContainerInterface;
use Skolkovo22\Common\Loader\ArrayImporterInterface;
use Exception;

class SimpleContainer implements ContainerInterface
{
    protected array $_dependencies = [];

    protected array $_arguments = [];

    public function __construct(private readonly ArrayImporterInterface $importer)
    {
    }

    /**
     * @param string $file
     *
     * @return void
     */
    public function importArguments(string $file): void
    {
        $this->_arguments = array_replace_recursive(
            $this->_arguments,
            $this->importer->importArrayFrom($file)
        );
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
        if (array_key_exists($interfaceOrClassName, $this->_dependencies)) {
            throw new Exception(
                sprintf('Dependency [%s] already exists', $interfaceOrClassName)
            );
        }

        $this->_dependencies[$interfaceOrClassName] = $className;
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
        if (!array_key_exists($interfaceOrClassName, $this->_dependencies)) {
            throw new Exception(
                sprintf('Unknown dependency [%s]', $interfaceOrClassName)
            );
        }

        if (is_object($this->_dependencies[$interfaceOrClassName])) {
            return $this->_dependencies[$interfaceOrClassName];
        }

        $dependency = $this->_dependencies[$interfaceOrClassName];

        $this->_dependencies[$interfaceOrClassName] = new $dependency(
            ...array_values($this->_arguments[$interfaceOrClassName] ?? [])
        );

        unset($dependency, $this->_arguments[$interfaceOrClassName]);
        return $this->_dependencies[$interfaceOrClassName];
    }
}
