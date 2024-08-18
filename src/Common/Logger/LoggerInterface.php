<?php

declare(strict_types=1);

namespace App\Common\Logger;

interface LoggerInterface
{
    /**
     * @param string $message
     *
     * @return void
     */
    public function info(string $message): void;
}
