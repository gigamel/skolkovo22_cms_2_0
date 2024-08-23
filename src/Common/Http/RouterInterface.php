<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Http;

use Exception;
use Skolkovo22\Common\Http\Protocol\ClientMessageInterface;

interface RouterInterface
{
    /**
     * @throws Exception
     */
    public function handle(ClientMessageInterface $request): RouteInterface;
    
    public function setSegment(string $segment, string $regEx): void;
    
    /**
     * @param string[] $methods
     */
    public function route(
        string $name,
        string $rule,
        string $controller,
        string $action,
        array $methods = ClientMessageInterface::HTTP_METHODS
    ): void;
}
