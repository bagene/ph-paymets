<?php

namespace Bagene\PhPayments\Xendit\Models;

use Bagene\PhPayments\Helpers\HostResolver;
use Bagene\PhPayments\Requests\Request;

/**
 * Xendit QR Request
 * @link https://xendit.github.io/apireference/?shell#qr-codes
 * @property-read array{
 *     reference_id: string,
 *     type: string,
 *     currency: string,
 *     amount?: int,
 * } $body
 */
class XenditCreateQrRequest extends Request implements XenditRequestInterface
{
    public function setDefaults(): void
    {
        $this->defaults = [];
    }

    public function getEndpoint(): string
    {
        return HostResolver::resolve(
            'Xendit',
            boolval(config('payments.xendit.use_sandbox'))
        ) . self::QR_ENDPOINT;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    /**
     * @return string[]
     */
    protected function getRequiredFields(): array
    {
        return [
            'reference_id',
            'type',
            'currency',
        ];
    }

    public function validate(string ...$fields): void
    {
        $fields = $this->requiredFields;
        parent::validate(...$fields);

        // Conditional Validation for Amount
        if ($this->body['type'] === 'STATIC') {
            parent::validate('amount');
        }
    }
}
