<?php

namespace Bagene\PhPayments\Requests;

use Psr\Http\Message\ResponseInterface;

class Response implements BaseResponse
{
    /** @var array<string, list<string|null>> $headers */
    protected array $headers = [];
    /** @var array<string, mixed>|array<int, array<string, mixed>>|array{} $body */
    protected array $body = [];

    public function __construct(ResponseInterface $response)
    {
        $this->setResponse($response);
    }

    protected function setResponse(ResponseInterface $response): void
    {
        $this->headers = $response->getHeaders();

        /** @var array<string, mixed>|array<int, array<string, mixed>>|array{} $body */
        $body = json_decode($response->getBody(), true) ?: [];
        $this->body = $body;
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
