<?php

namespace Bagene\PhPayments;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\Maya\MayaGatewayInterface;
use Bagene\PhPayments\Xendit\XenditGatewayInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

abstract class PaymentGateway implements PaymentGatewayInferface
{
    protected Client $client;
    public function __construct(array $args = [], ?Client $client = null)
    {
        $this->client = $client ?? new Client();
    }

    public function setAttribute(string $name, mixed $value): PaymentGatewayInferface
    {
        $reflection = new \ReflectionClass($this);

        // Check if the property exists
        foreach ($reflection->getProperties() as $property) {
            if ($property->getName() === $name) {
                $this->{$name} = $value;
                return $this;
            }
        }

        return $this;
    }

    public function setAttributes(array $attributes): PaymentGatewayInferface
    {
        foreach ($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }

        return $this;
    }

    protected abstract function verifyWebhook(Request|array $request, ?array $headers = []): array;

    public abstract function parseWebhookPayload(array|Request $request, ?array $headers = []): array;

    public function cacheWebhookId(string $id, string $cacheKey = 'webhook', $isLaravel = true): void
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
