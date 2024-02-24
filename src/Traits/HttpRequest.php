<?php

namespace Bagene\PhPayments\Traits;

use Bagene\PhPayments\Exceptions\MethodNotFoundException;
use Bagene\PhPayments\Gateway;
use Bagene\PhPayments\PaymentGatewayInferface;
use Bagene\PhPayments\Requests\BaseRequest;
use Bagene\PhPayments\Requests\BaseResponse;
use Bagene\PhPayments\Requests\Response;
use Bagene\PhPayments\Xendit\Models\XenditCreateInvoiceResponse;
use Bagene\PhPayments\Xendit\Models\XenditCreateQrResponse;

/**
 * Trait HttpRequest
 *
 * @const string GATEWAY_NAME
 * @property string $method
 * @property string $model
 * @property-read PaymentGatewayInferface $gateway
 * @package Bagene\PhPayments\Traits
 * @link Gateway
 */
trait HttpRequest
{
    /**
     * @param array<string, mixed>|array<list<mixed>> $payload
     * @throws MethodNotFoundException
     * @return BaseResponse
     */
    public function create(array $payload): BaseResponse
    {
        $this->method = 'Create';
        $request = $this->getRequestClass($payload);

        return $request->send();
    }

    /**
     * @param array<string, mixed>|array<list<mixed>>|array{} $payload
     * @throws MethodNotFoundException
     */
    public function get(array $payload = []): BaseResponse
    {
        $this->method = 'Get';
        $request = $this->getRequestClass($payload);
        return $request->send();
    }

    /**
     * Magic function to get the request class
     * @param array<string, mixed>|array<list<mixed>>|array{} $payload
     * @throws MethodNotFoundException
     */
    protected function getRequestClass(array $payload = []): BaseRequest
    {
        $className = $this->getRequestClassName();

        /** @var BaseRequest $request */
        $request = new $className($this->gateway->getHeaders(), $payload);

        return $request;
    }

    /**
     * Get the request class name
     * @return string
     * @throws MethodNotFoundException
     */
    protected function getRequestClassName(): string
    {
        $prefix = 'Bagene\\PhPayments\\' . $this->getGatewayName() . '\\Models\\';

        $className = $prefix . self::GATEWAY_NAME . $this->method . $this->model . 'Request';
        if (!class_exists($className)) {
            throw new MethodNotFoundException('Method not found: ' . $this->method . $this->model . 'Request');
        }

        return $className;
    }
}
