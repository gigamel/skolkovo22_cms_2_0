<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Loader;

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
