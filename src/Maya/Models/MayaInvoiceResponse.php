<?php

namespace Bagene\PhPayments\Maya\Models;

use Bagene\PhPayments\Requests\Response;
use Psr\Http\Message\ResponseInterface;

abstract class MayaInvoiceResponse extends Response
{
    protected string $redirectUrl;

    protected function setResponse(ResponseInterface $response): void
    {
        parent::setResponse($response);
        $this->redirectUrl = $this->body['redirectUrl'];
    }

    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }
}
