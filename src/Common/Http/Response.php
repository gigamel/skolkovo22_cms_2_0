<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Http;

use Skolkovo22\Common\Http\Protocol\ServerMessageInterface;

class Response implements ServerMessageInterface
{
    /** @var string[] */
    protected array $headers = [];
    
    /**
     * @param string $body
     * @param int $statusCode
     * @param string[] $headers
     */
    public function __construct(
        protected string $body = '',
        protected int $statusCode = self::STATUS_OK,
        array $headers = []
    ) {
        $this->addHeaders($headers);
    }
    
    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $header
     * @param string $value
     *
     * @return void
     */
    public function addHeader(string $header, string $value): void
    {
        $this->headers[$header] = $value;
    }

    /**
     * @param string[] $headers
     *
     * @return void
     */
    public function addHeaders(array $headers = []): void
    {
        foreach ($headers as $header => $value) {
            $this->addHeader($header, $value);
        }
    }
    
    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return void
     */
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
