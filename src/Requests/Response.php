<?php

namespace Bagene\PhPayments\Requests;

use Psr\Http\Message\ResponseInterface;

abstract class Response implements BaseResponse
{
    protected array $headers = [];
    protected ?array $body = [];

    public function __construct(ResponseInterface $response)
    {
        $this->setResponse($response);
    }

    public function setResponse(ResponseInterface $response): void
    {
        $this->headers = $response->getHeaders();
        $this->body = json_decode($response->getBody(), true);
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): array
    {
        return $this->body;
    }
}
