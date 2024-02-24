<?php

namespace Bagene\PhPayments\Traits;

use Bagene\PhPayments\Requests\BaseRequest;
use Bagene\PhPayments\Requests\BaseResponse;

/**
 * Trait HasExtraRequest
 * @method array getHeaders()
 * @package Bagene\PhPayments\Traits
 */
trait HasExtraRequest
{
    protected function request(string $className): BaseResponse
    {
        /** @var BaseRequest $request */
        $request = new $className($this->getHeaders(), $this->getBody());

        return $request->send();
    }
}
