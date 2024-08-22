<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Http;

use Skolkovo22\Common\Http\Protocol\ServerMessageInterface;

use function header;
use function headers_sent;
use function sprintf;

class Response implements ServerMessageInterface
{
    /** @var string[] */
    protected array $headers = [];
    
    /**
     * @param string[] $headers
     */
    public function __construct(
        protected string $body = '',
        protected int $statusCode = self::STATUS_OK,
        array $headers = []
    ) {
        $this->addHeaders($headers);
    }
    
    public function getBody(): string
    {
        return $this->body;
    }
    
    public function addHeader(string $header, string $value): void
    {
        $this->headers[$header] = $value;
    }

    /**
     * @param string[] $headers
     */
    public function addHeaders(array $headers = []): void
    {
        foreach ($headers as $header => $value) {
            $this->addHeader($header, $value);
        }
    }
    
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
    
    public function send(): void
    {
        if (headers_sent()) {
            return;
        }
        
        foreach ($this->headers as $header => $value) {
            header(sprintf('%s: %s', $header, $value), true);
        }
        
        header(sprintf('%s %d %s', 'HTTP/1.1', $this->getStatusCode(), 'Some Status Message')); // Todo
    }
}
