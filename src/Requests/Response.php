<?php

namespace Bagene\PhPayments\Requests;

use Psr\Http\Message\ResponseInterface;

abstract class Response implements BaseResponse
{
    /** @var array<string, list<string|null>> $headers */
    protected array $headers = [];
    /** @var array{...} $body */
    protected array $body = [];

    public function __construct(ResponseInterface $response)
    {
        $this->setResponse($response);
    }

    protected function setResponse(ResponseInterface $response): void
    {
        $this->headers = $response->getHeaders();
        $this->body = json_decode($response->getBody(), true) ?: [];
    }

    /** @return array<string, list<string|null>> */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /** @return array{...} */
    public function getBody(): array
    {
        return $this->body;
    }
}
