<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Loader;

interface ImporterInterface
{
    public function importFrom(string $file): void;
}
