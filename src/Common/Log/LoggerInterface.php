<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Log;

interface LoggerInterface
{
    /**
     * @param string $message
     *
     * @return void
     */
    public function info(string $message): void;
}
