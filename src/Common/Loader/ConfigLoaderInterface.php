<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Loader;

interface ConfigLoaderInterface extends ImporterInterface
{
    public function getConfig(string $option, mixed $default = null): mixed;
}
