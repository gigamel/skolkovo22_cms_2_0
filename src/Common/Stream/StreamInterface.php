<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Stream;

interface StreamInterface
{
    public function read(int $length = 0): string;
    
    public function seek(int $offset = 0): bool;
    
    public function write(string $data, ?int $length = null): int;
    
    public function close(): bool;
}
