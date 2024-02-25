<?php

namespace Bagene\PhPayments\Xendit\Models;

use Bagene\PhPayments\Helpers\HostResolver;
use Bagene\PhPayments\Requests\Request;
use Bagene\PhPayments\Exceptions\RequestException;
use GuzzleHttp\Exception\GuzzleException;

class XenditGetInvoiceRequest extends Request implements XenditRequestInterface
{
    public function setDefaults(): void
    {
        $this->defaults = [];
    }

    /**
     * @return string
     * @throws RequestException
     */
    public function getEndpoint(): string
    {
        $endpoint = HostResolver::resolve(
            'Xendit',
            boolval(config('payments.xendit.use_sandbox'))
        ) . self::INVOICE_ENDPOINT;

        if (isset($this->body['id'])) {
            $endpoint .= '/' . $this->body['id'];
        } elseif (isset($this->body['external_id'])) {
            $endpoint .= '?external_id=' . $this->body['external_id'];
        } else {
            throw new RequestException('Either id or external_id is required');
        }

        return $endpoint;
    }

    public function getMethod(): string
    {
        return 'GET';
    }
}
