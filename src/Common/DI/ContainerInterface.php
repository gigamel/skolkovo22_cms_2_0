<?php

declare(strict_types=1);

namespace Skolkovo22\Common\DI;

use Exception;

interface ContainerInterface
{
    public function importArguments(string $file): void;

    /**
     * @throws Exception
     */
    public function setDependency(string $interfaceOrClassName, string $className): void;

    /**
     * @throws Exception
     */
    public function getDependency(string $interfaceOrClassName): object;
}
