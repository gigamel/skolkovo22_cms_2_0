<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Http;

interface RouteInterface
{
    public function getRule(): string;

    public function getController(): string;
    
    public function getAction(): string;

    /**
     * @return string[]
     */
    public function getMethods(): array;
}
