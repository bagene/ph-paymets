<?php

namespace Bagene\PhPayments\Requests;

use Psr\Http\Message\ResponseInterface;

interface BaseResponse
{
    public function getHeaders(): array;
    public function setResponse(ResponseInterface $response): void;

    public function getBody(): array;
}
