<?php

namespace Bagene\PhPayments\Requests;

use Bagene\PhPayments\Exceptions\RequestException;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

abstract class Request implements BaseRequest
{
    protected string $endpoint;
    protected string $method;
    protected array $headers;
    protected array $body = [];
    protected array $defaults;

    public function __construct(array $headers, array $body)
    {
        $this->setHeaders($headers);
        $this->setBody($body);
        $this->setDefaults();
        $this->endpoint = $this->getEndpoint();
        $this->method = $this->getMethod();
    }

    abstract function setDefaults(): void;

    abstract function getEndpoint(): string;
    abstract function getMethod(): string;

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setBody(array $body): void
    {
        $this->body = $body;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * @return ResponseInterface
     * @throws Exception
     * @throws RequestException
     * @throws ClientException
     * @throws GuzzleException
     */
    public function sendRequest(): ResponseInterface
    {
        $client = new Client();
        $headers = $this->getHeaders();
        $options = [
            'headers' => $headers,
        ];
        if ($this->method === 'GET') {
            $options['query'] = $this->body;
        } else {
            $options['json'] = $this->body;
        }

        try {
            return $client->request($this->method, $this->endpoint, $options);
        } catch (Exception $e) {
            throw new RequestException($e->getMessage(), $e->getCode(), $e);
        }
    }


    abstract public function send(): BaseResponse;
}
