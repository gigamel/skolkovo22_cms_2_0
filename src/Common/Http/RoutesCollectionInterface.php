<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Http;

use Exception;

interface RoutesCollectionInterface
{
    public function set(string $name, RouteInterface $route): void;
    
    /**
     * @throws Exception
     */
    public function get(string $name): RouteInterface;
    
    public function has(string $name): bool;
    
    /**
     * @return RouteInterface[]
     */
    public function getCollection(): array;
}
