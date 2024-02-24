<?php

namespace Bagene\PhPayments;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\Maya\MayaGatewayInterface;
use Bagene\PhPayments\Xendit\XenditGatewayInterface;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

abstract class PaymentGateway implements PaymentGatewayInferface
{
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

    /**
     * @return array<string, list<string|null>>
     */
    protected abstract function verifyWebhook(Request $request): array;

    public abstract function parseWebhookPayload(Request $request): array;

    /**
     * @throws RequestException
     */
    public function cacheWebhookId(string $cacheKey = 'webhook'): void
    {
        if (Cache::has($cacheKey)) {
            throw new RequestException('Duplicate webhook');
        }

        Cache::put($cacheKey, true, 60);
    }
}
