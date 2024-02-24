<?php

namespace Bagene\PhPayments\Maya;

use Bagene\PhPayments\Gateway;
use Bagene\PhPayments\Requests\BaseResponse;
use Bagene\PhPayments\Traits\HttpRequest;

/**
 * @method string getRequestedClassName()
 */
final class Maya implements Gateway
{
    use HttpRequest;
    /**
     * @inheritDoc
     */
    protected const GATEWAY_NAME = 'Maya';
    protected string $method = 'Create';
    protected string $model = '';

    public function __construct(protected MayaGatewayInterface $gateway)
    {
    }

    public function checkout(): self
    {
        $this->model = 'Checkout';
        return $this;
    }

    public function wallet(): self
    {
        $this->model = 'Wallet';
        return $this;
    }

    public function token(): self
    {
        $this->model = 'Token';
        return $this;
    }

    public function payment(): self
    {
        $this->model = 'Payment';
        return $this;
    }
}
