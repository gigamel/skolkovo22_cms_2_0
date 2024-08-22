<?php

declare(strict_types=1);

namespace Skolkovo22\Http;

use Skolkovo22\Common\DI\ContainerInterface;

interface DependenciesProviderInterface
{
    public function setupDependencies(ContainerInterface $container): void;
}
