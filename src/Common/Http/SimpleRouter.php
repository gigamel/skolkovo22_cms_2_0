<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Http;

use Exception;
use Skolkovo22\Common\Http\Protocol\ClientMessageInterface;

class SimpleRouter implements RouterInterface
{
    protected array $_segments = [];
    
    protected RoutesCollectionInterface $collection;
    
    public function __construct(
        array $segments = [],
        ?RoutesCollectionInterface $collection = null
    ) {
        foreach ($segments as $segment => $regEx) {
            $this->setSegment($segment, $regEx);
        }
        
        $this->collection = $collection ?? new SimpleRoutesCollection();
    }
    
    /**
     * @throws Exception
     */
    public function handle(ClientMessageInterface $request): RouteInterface
    {
        foreach ($this->collection->getCollection() as $name => $route) {
            if (!in_array($request->getMethod(), $route->getMethods(), true)) {
                continue;
            }
            
            if ($request->getPath() === $route->getRule()) {
                return $route;
            }
        }
        
        throw new Exception('Undefined route');
    }
    
    public function route(
        string $name,
        string $rule,
        string $controller,
        string $action,
        array $methods = ClientMessageInterface::HTTP_METHODS
    ): void {
        $this->collection->set($name, new SimpleRoute($rule, $controller, $action, $methods));
    }
    
    public function setSegment(string $segment, string $regEx): void
    {
        $this->_segments[$segment] = $regEx;
    }
}
