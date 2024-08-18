<?php

declare(strict_types=1);

namespace App\Common\Loader;

use Exception;

interface ArrayImporterInterface
{
    /**
     * @param string $file
     *
     * @return array
     *
     * @throws Exception
     */
    public function importArrayFrom(string $file): array;
}
