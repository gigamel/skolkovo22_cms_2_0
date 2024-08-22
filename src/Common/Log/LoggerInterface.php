<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Log;

interface LoggerInterface
{
    public function info(string $message): void;
}
