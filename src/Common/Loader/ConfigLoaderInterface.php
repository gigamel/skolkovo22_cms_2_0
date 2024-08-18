<?php

declare(strict_types=1);

namespace App\Common\Loader;

interface ConfigLoaderInterface extends ImporterInterface
{
    /**
     * @param string $option
     * @param mixed $default
     *
     * @return mixed
     */
    public function getConfig(string $option, mixed $default = null): mixed;
}
