<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Loader;

class ConfigLoader implements ConfigLoaderInterface
{
    protected array $_config = [];

    public function __construct(protected readonly ArrayImporterInterface $importer)
    {
    }
    
    public function importFrom(string $file): void
    {
        $this->_config = array_replace_recursive(
            $this->_config,
            $this->importer->importArrayFrom($file)
        );
    }
    
    public function getConfig(string $option, mixed $default = null): mixed
    {
        $options = explode('.', $option);

        $config = $this->_config[array_shift($options)] ?? $default;
        foreach ($options as $item) {
            $config = $config[$item] ?? $default;
            if ($default === $config) {
                break;
            }
        }

        if ($default === $config) {
            unset($config, $options);
            return $default;
        }

        return $config;
    }
}
