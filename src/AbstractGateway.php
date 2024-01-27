<?php

namespace Bagene\PhPayments;

use GuzzleHttp\Client;

abstract class AbstractGateway implements PaymentGatewayInferface
{
    protected function getEndpoint(string $endpoint): string
    {
        $baseUrl = config('payments.xendit.is_production')
            ? static::PRODUCTION_BASE_URL
            : static::SANDBOX_BASE_URL;
        return $baseUrl . $endpoint;
    }

    protected function sendRequest(string $method, string $endpoint, array $data = [])
    {
        $client = new Client();
        $headers = $this->getHeaders();
        $options = [
            'headers' => $headers,
        ];
        if ($method === 'GET') {
            $options['query'] = $data;
        } else {
            $options['json'] = $data;
        }
        $response = $client->request($method, $endpoint, $options);
        $body = $response->getBody();
        return json_decode($body, true);
    }

    protected function validatePayload(string $type, array $data): void
    {
        $constName = 'static::' . $type;
        if (!defined($constName)) {
            throw new \InvalidArgumentException("Invalid type: {$type}");
        } else {
            $requiredKeys = constant($constName);
            foreach ($requiredKeys as $key) {
                if (!array_key_exists($key, $data)) {
                    throw new \InvalidArgumentException("Missing required key: {$key}");
                }
            }
        }
    }
}
