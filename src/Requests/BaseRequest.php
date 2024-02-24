<?php

namespace Bagene\PhPayments\Requests;

use Psr\Http\Message\ResponseInterface;

interface BaseRequest
{
    /** @param array<string, string> $headers */
    public function setHeaders(array $headers): self;
    /**
     * @param array<string, mixed> $body
     */
    public function setBody(array $body): self;
    public function validate(string ...$fields): void;
    /** @return array<string, string> */
    public function getHeaders(): array;
    /** @return array<string, mixed> */
    public function getBody(): array;

    public function setDefaults(): void;

    public function send(): BaseResponse;
}
