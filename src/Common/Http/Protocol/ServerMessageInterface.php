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

    /**
     * @return string
     */
    public function getBody(): string;

    /**
     * @param string $header
     * @param string $value
     *
     * @return void
     */
    public function addHeader(string $header, string $value): void;

    /**
     * @param string[] $headers
     *
     * @return void
     */
    public function addHeaders(array $headers = []): void;

    /**
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * @return void
     */
    public function send(): void;
}
