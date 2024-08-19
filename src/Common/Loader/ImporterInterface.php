<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Loader;

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
