<?php

namespace Bagene\PhPayments;

use Bagene\PhPayments\Exceptions\RequestException;
use GuzzleHttp\Client;
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

    /**
     * @throws RequestException
     */
    public function cacheWebhookId(string $cacheKey = 'webhook'): void
    {
        if (cache()->has($cacheKey)) {
            throw new RequestException('Duplicate webhook');
        }

        cache()->put($cacheKey, true, 60);
    }
}
