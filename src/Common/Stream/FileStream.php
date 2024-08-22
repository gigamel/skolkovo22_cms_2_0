<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Stream;

use Exception;

final class FileStream implements StreamInterface
{
    private $resource;

    /**
     * @throws Exception
     */
    public function __construct(string $filename, string $mode = 'a')
    {
        $this->resource = fopen($filename, $mode);
        if (!$this->resource) {
            throw new Exception(sprintf('Could not open [%s]', $filename));
        }
    }
    
    public function read(int $length = 0): string
    {
        return fread($this->resource, $length) ?: '';
    }
    
    public function seek(int $offset = 0): bool
    {
        return fseek($this->resource, $offset);
    }
    
    public function write(string $data, ?int $length = null): int
    {
        return fwrite($this->resource, $data, $length) ?: 0;
    }
    
    public function close(): bool
    {
        return fclose($this->resource);
    }
}
