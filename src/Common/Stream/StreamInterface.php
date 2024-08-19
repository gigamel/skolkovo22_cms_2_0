<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Stream;

interface StreamInterface
{
    /**
     * @param int $length
     *
     * @return string
     */
    public function read(int $length = 0): string;

    /**
     * @param int $offset
     *
     * @return bool
     */
    public function seek(int $offset = 0): bool;

    /**
     * @param string $data
     *
     * @return int
     */
    public function write(string $data, ?int $length = null): int;

    /**
     * @return bool
     */
    public function close(): bool;
}
