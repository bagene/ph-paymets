<?php

namespace Bagene\PhPayments;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\Xendit\XenditGatewayInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

abstract class PaymentGateway implements XenditGatewayInterface
{
    public function __construct(array $args = [], ?Client $client = null)
    {
        $this->client = $client ?? new Client();
    }

    public static function getGateway(string $gateway, array $args = []): PaymentGateway
    {
        $gateway = ucfirst($gateway);
        $gatewayClass = "Bagene\\PhPayments\\{$gateway}\\{$gateway}Gateway";
        if (!class_exists($gatewayClass)) {
            throw new \InvalidArgumentException("Invalid gateway: {$gateway}");
        }

        return new $gatewayClass($args);
    }

    public function validatePayload(string $type, array $data): void
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
