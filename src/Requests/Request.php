<?php

namespace Bagene\PhPayments\Requests;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\Helpers\ResponseFactory;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use function PHPUnit\Framework\stringContains;

abstract class Request implements BaseRequest
{
    protected ClientInterface $client;
    protected string $endpoint;
    protected string $method;
    /** @var array<string, string> $headers */
    protected array $headers;
    /** @var array<string, mixed> $body  */
    protected array $body = [];
    /** @var array<string, string>|array<string, list<mixed|null>> $defaults */
    protected array $defaults;

    /** @var string[] $requiredFields */
    public array $requiredFields;

    /**
     * @param array<string, string> $headers
     * @param array<string, mixed> $body
     */
    public function __construct(array $headers, array $body)
    {
        /** @var ClientInterface $client */
        $client = app(Client::class);
        $this->client = $client;
        $this->setHeaders($headers);
        $this->setBody($body);
        $this->setDefaults();
        $this->requiredFields = $this->getRequiredFields();
        $this->endpoint = $this->getEndpoint();
        $this->method = $this->getMethod();
    }

    abstract function setDefaults(): void;

    abstract function getEndpoint(): string;
    abstract function getMethod(): string;

    /** @return string[] */
    protected function getRequiredFields(): array
    {
        return [];
    }

    /** @param array<string, string> $headers */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    /** @param array<string, mixed> $body */
    public function setBody(array $body): self
    {
        $this->body = $body;

        return $this;
    }

    /** @return array<string, mixed> */
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
    protected function sendRequest(): ResponseInterface
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
     * @return BaseResponse
     * @throws RequestException
     * @throws GuzzleException
     */
    public function send(): BaseResponse
    {
        $this->extraRequest();
        $this->validate(...$this->requiredFields);

        $response = $this->sendRequest();

        $responseClass = $this->getResponseClass();
        return ResponseFactory::createResponse($responseClass, $response);
    }

    protected function extraRequest(): void
    {
    }

    protected function getResponseClass(): string
    {
        return str_replace('Request', 'Response', static::class);
    }

    /**
     * @throws RequestException
     */
    public function validate(string ...$fields): void
    {
        $errors = [];
        foreach ($fields as $field) {
            if (str_contains($field, '.')) {
                $nestedFields = explode('.', $field);
                $this->validateNestedFields($this->body, $nestedFields, $errors);
                continue;
            }

            if (!array_key_exists($field, $this->body)) {
                $errors[] = $field;
            }
        }

        if (!empty($errors)) {
            $errorFields = implode(', ', $errors);
            throw new RequestException("Missing required fields: {$errorFields}", 422);
        }
    }

    /**
     * @param array<string, mixed> $data
     * @param array<int, string> $nestedFields
     * @param array<int, string> $errors
     * @param int $index
     * @return void
     */
    public function validateNestedFields(array $data, array $nestedFields, array &$errors, int $index = 0): void
    {
        $field = $nestedFields[$index];

        if (!array_key_exists($field, $data)) {
            $error = implode('.', array_slice($nestedFields, 0, $index + 1));
            $errors[] = $error;
            return;
        }

        if (count($nestedFields) > $index + 1) {
            $this->validateNestedFields(
                is_array($data[$field]) ? $data[$field] : [],
                $nestedFields,
                $errors,
                $index + 1
            );
        }
    }
}
