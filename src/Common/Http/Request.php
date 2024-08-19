<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Http;

use Skolkovo22\Common\Http\Protocol\ClientMessageInterface;

class Request implements ClientMessageInterface
{
    /** @var array */
    protected $_headers = [];
    
    public function __construct()
    {
        foreach ($_SERVER as $key => $value) {
            if (0 !== \strpos($key, 'HTTP_')) {
                continue;
            }
            
            $this->_headers[ucwords(strtolower(\substr($key, 5)), '_')] = $value;
        }
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return \strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return \parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->_headers;
    }

    /**
     * @param string $header
     *
     * @return string|null
     */
    public function getHeader(string $header): ?string
    {
        return $this->_headers[str_replace('-', '_', $header)] ?? null;
    }

    /**
     * @param string $header
     *
     * @return bool
     */
    public function hasHeader(string $header): bool
    {
        return array_key_exists(str_replace('-', '_', $header), $this->_headers);
    }
}
