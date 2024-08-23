<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Http;

use Exception;
use Skolkovo22\Common\Http\Protocol\ClientMessageInterface;

use function strtoupper;
use function trim;

class SimpleRoute implements RouteInterface
{
    protected array $methods = [];
    
    /**
     * @param string[] $methods
     *
     * @throws Exception
     */
    public function __construct(
        protected readonly string $rule,
        protected readonly string $controller,
        protected readonly string $action,
        array $methods = ClientMessageInterface::HTTP_METHODS
    ) {
        foreach ($methods as $method) {
            $method = strtoupper(trim($method));
            if (!in_array($method, ClientMessageInterface::HTTP_METHODS, true)) {
                throw new Exception(
                    sprintf(
                        'Invalid HTTP method [%s]. Route name [%s]',
                        $method,
                        $name
                    )
                );
            }
            
            $this->methods[] = $method;
        }
    }
    
    public function getRule(): string
    {
        return $this->rule;
    }

    public function getController(): string
    {
        return $this->controller;
    }
    
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return string[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }
}
