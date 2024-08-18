<?php

declare(strict_types=1);

namespace App\Common\Loader;

use Exception;

interface ImporterInterface
{
    /**
     * @param string $file
     *
     * @return void
     *
     * @throws Exception
     */
    public function importFrom(string $file): void;
}
