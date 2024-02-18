<?php

namespace Bagene\PhPayments\Requests;

use Psr\Http\Message\ResponseInterface;

interface BaseResponse
{
    /** @return array<string, string>|array<int, list<string>> */
    public function getHeaders(): array;

    /** @return array<string, mixed>|null */
    public function getBody(): ?array;
}
