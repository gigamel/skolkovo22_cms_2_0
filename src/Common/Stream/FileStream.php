<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Stream;

final class FileStream implements StreamInterface
{
    private $resource;

    public function __construct(string $filename, string $mode = 'a')
    {
        $this->resource = fopen($filename, $mode);
    }

    /**
     * @param int $length
     *
     * @return string
     */
    public function read(int $length = 0): string
    {
        return fread($this->resource, $length) ?: '';
    }

    /**
     * @param int $offset
     *
     * @return bool
     */
    public function seek(int $offset = 0): bool
    {
        return fseek($this->resource, $offset);
    }

    /**
     * @param string $data
     *
     * @return int
     */
    public function write(string $data, ?int $length = null): int
    {
        return fwrite($this->resource, $data, $length) ?: 0;
    }

    /**
     * @return bool
     */
    public function close(): bool
    {
        fclose($this->resource);
    }
}
