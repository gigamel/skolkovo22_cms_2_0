<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Loader;

use Exception;

class PHPFileArrayImporter implements ArrayImporterInterface
{
    /**
     * @param string $file
     *
     * @return array
     *
     * @throws Exception
     */
    public function importArrayFrom(string $file): array
    {
        if (!file_exists($file)) {
            return [];
        }

        $arguments = require_once($file);
        return is_array($arguments) ? $arguments : [];
    }
}
