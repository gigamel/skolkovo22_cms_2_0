<?php

declare(strict_types=1);

namespace Skolkovo22\Common\Http\Protocol;

interface ServerMessageInterface
{
    public const
        STATUS_OK = 200,
        STATUS_MOVED_PERMANENTLY = 301,
        STATUS_FORBIDDEN = 403,
        STATUS_NOT_FOUND = 404,
        STATUS_INTERNAL_SERVER_ERROR = 500
    ;

    public const MESSAGES = [
        self::STATUS_OK => 'OK',
        self::STATUS_MOVED_PERMANENTLY => 'Moved Permanently',
        self::STATUS_FORBIDDEN => 'Forbidden',
        self::STATUS_NOT_FOUND => 'Not Found',
        self::STATUS_INTERNAL_SERVER_ERROR => 'Internal Server Error',
    ];
    
    public function getBody(): string;
    
    public function addHeader(string $header, string $value): void;

    /**
     * @param string[] $headers
     */
    public function addHeaders(array $headers = []): void;
    
    public function getStatusCode(): int;
    
    public function send(): void;
}
