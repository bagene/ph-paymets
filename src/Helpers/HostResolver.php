<?php

namespace Bagene\PhPayments\Helpers;

use Bagene\PhPayments\Maya\Models\MayaRequest;
use Bagene\PhPayments\Xendit\Models\XenditRequestInterface;

final class HostResolver
{
    public static function resolve(string $gateway, bool $isSandbox = false): string
    {
        $interface = match ($gateway) {
            'Xendit' => XenditRequestInterface::class,
            'Maya' => MayaRequest::class,
            default => throw new \InvalidArgumentException("Unknown gateway: $gateway"),
        };

        return $isSandbox ? $interface::SANDBOX_BASE_URL : $interface::PRODUCTION_BASE_URL;
    }
}
