<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Http;

use Skolkovo22\Common\Http\Protocol\ClientMessageInterface;

use function array_key_exists;
use function parse_url;
use function str_replace;
use function strtolower;
use function strtoupper;
use function substr;
use function ucwords;

class Request implements ClientMessageInterface
{
    /** @var string[] */
    protected array $_headers = [];
    
    public function __construct()
    {
        foreach ($_SERVER as $key => $value) {
            if (0 !== \strpos($key, 'HTTP_')) {
                continue;
            }
            
            $this->_headers[ucwords(strtolower(substr($key, 5)), '_')] = $value;
        }
    }
    
    public function getMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }
    
    public function getPath(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
    }
    
    public function getHeaders(): array
    {
        return $this->_headers;
    }
    
    public function getHeader(string $header): ?string
    {
        return $this->_headers[str_replace('-', '_', $header)] ?? null;
    }
    
    public function hasHeader(string $header): bool
    {
        return array_key_exists(str_replace('-', '_', $header), $this->_headers);
    }
}
