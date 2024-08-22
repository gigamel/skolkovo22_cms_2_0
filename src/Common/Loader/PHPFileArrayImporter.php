<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Loader;

class PHPFileArrayImporter implements ArrayImporterInterface
{
    public function importArrayFrom(string $file): array
    {
        if (!file_exists($file)) {
            return [];
        }

        $arguments = require_once($file);
        return is_array($arguments) ? $arguments : [];
    }
}
