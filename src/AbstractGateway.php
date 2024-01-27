<?php

namespace Bagene\PhPayments;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\Xendit\XenditGatewayInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

abstract class AbstractGateway implements XenditGatewayInterface
{
    protected function getEndpoint(string $endpoint): string
    {
        $baseUrl = config('payments.xendit.is_production')
            ? static::PRODUCTION_BASE_URL
            : static::SANDBOX_BASE_URL;
        return $baseUrl . $endpoint;
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array $data
     * @return mixed
     * @throws RequestException
     * @throws GuzzleException
     */
    protected function sendRequest(string $method, string $endpoint, array $data = []): array
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

        try {
            $response = $client->request($method, $endpoint, $options);
            $body = $response->getBody();
            return json_decode($body, true);
        } catch (ClientException $e) {
            throw new RequestException($e->getMessage(), $e->getCode(), $e);
        }
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

    public function parseWebhookPayload(array|Request $request, ?array $headers = []): array
    {
        if (
            empty($request->headers->get(static::WEBHOOK_HEADER_KEYS))
            && empty($headers[static::WEBHOOK_HEADER_KEYS])
        ) {
            throw new \InvalidArgumentException('Missing required header: x-callback-token');
        }

        if ($request instanceof Request) {
            return $request->headers->all();
        }

        return $headers ?? [];
    }

    protected function cacheWebhookId(string $id, string $cacheKey = 'webhook', $isLaravel = true): void
    {
        $cacheKey = $cacheKey . '-' . $id;
        if ($isLaravel) {
            if (cache()->has($cacheKey)) {
                throw new \InvalidArgumentException('Duplicate webhook');
            }

            cache()->put($cacheKey, $id, 60);
            return;
        }

        if (file_exists("cache/{$cacheKey}")) {
            $expireTime = file_get_contents("cache/{$cacheKey}-expire");
            if ($expireTime > time()) {
                throw new \InvalidArgumentException('Duplicate webhook');
            }
        }

        file_put_contents("cache/{$cacheKey}", 'true');
        $expireTime = time() + 60;
        file_put_contents("cache/{$cacheKey}-expire", $expireTime);
    }
}
