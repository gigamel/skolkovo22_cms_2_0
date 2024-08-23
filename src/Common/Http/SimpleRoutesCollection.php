<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Http;

use Exception;

class SimpleRoutesCollection implements RoutesCollectionInterface
{
    protected array $_collection = [];
    
    /**
     * @param RouteInterface[] $routes
     */
    public function __construct(array $routes = [])
    {
        foreach ($routes as $name => $route) {
            $this->set($name, $route);
        }
    }
        
    public function set(string $name, RouteInterface $route): void
    {
        $this->_collection[$name] = $route;
    }
    
    /**
     * @throws Exception
     */
    public function get(string $name): RouteInterface
    {
        if ($this->has($name)) {
            return $this->_collection[$name];
        }
        
        throw new Exception(sprintf('Route [%s] is not exists', $name));
    }
    
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->_collection);
    }
    
    /**
     * @return RouteInterface[]
     */
    public function getCollection(): array
    {
        return $this->_collection;
    }
}
