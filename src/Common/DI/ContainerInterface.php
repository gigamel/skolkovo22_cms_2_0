<?php

declare(strict_types=1);

namespace App\Common\DI;

use Exception;

interface ContainerInterface
{
    /**
     * @param string $file
     *
     * @return void
     */
    public function importArguments(string $file): void;

    /**
     * @param string $interfaceOrClassName
     * @param string $className
     *
     * @return void
     *
     * @throws Exception
     */
    public function setDependency(string $interfaceOrClassName, string $className): void;

    /**
     * @param string $interfaceOrClassName
     *
     * @return object
     *
     * @throws Exception
     */
    public function getDependency(string $interfaceOrClassName): object;
}
