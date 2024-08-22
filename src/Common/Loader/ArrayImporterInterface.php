<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Loader;

interface ArrayImporterInterface
{
    public function importArrayFrom(string $file): array;
}
