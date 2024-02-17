<?php

namespace Bagene\PhPayments\Requests;

use Psr\Http\Message\ResponseInterface;

interface BaseRequest
{
    public function validate(string ...$fields): void;
    public function getHeaders(): array;

    public function getBody(): array;

    public function setDefaults(): void;

    public function send(): BaseResponse;
}
