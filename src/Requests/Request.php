<?php

namespace Bagene\PhPayments\Requests;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\Xendit\Models\XenditInvoiceResponse;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

abstract class Request implements BaseRequest
{
    protected ClientInterface $client;
    protected string $endpoint;
    protected string $method;
    protected array $headers;
    protected array $body = [];
    protected array $defaults;

    public array $requiredFields;

    public function __construct(array $headers, array $body)
    {
        $this->client = app(Client::class);
        $this->setHeaders($headers);
        $this->setBody($body);
        $this->setDefaults();
        $this->setRequireFields();
        $this->endpoint = $this->getEndpoint();
        $this->method = $this->getMethod();
    }

    abstract function setDefaults(): void;

    abstract function getEndpoint(): string;
    abstract function getMethod(): string;

    protected function setRequireFields(): void
    {
        $this->requiredFields = [];
    }

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
        $this->validate(...$this->requiredFields);

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
            return $this->client->request($this->method, $this->endpoint, $options);
        } catch (Exception $e) {
            throw new RequestException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @throws RequestException
     */
    public function validate(string ...$fields): void
    {
        $errors = [];
        foreach ($fields as $field) {
            if (!array_key_exists($field, $this->body)) {
                $errors[] = $field;
            }
        }

        if (!empty($errors)) {
            $errorFields = implode(', ', $errors);
            throw new RequestException("Missing required fields: {$errorFields}");
        }
    }

    /**
     * @throws RequestException
     * @throws GuzzleException
     */
    abstract public function send(): ?BaseResponse;

    public function toArray(): array
    {
        return $this->body;
    }
}
