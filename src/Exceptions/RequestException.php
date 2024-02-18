<?php

namespace Bagene\PhPayments\Exceptions;

class RequestException extends \Exception
{
    /** @param string[]|string $message */
    public function __construct(array|string $message = [], int $code = 500, \Throwable $previous = null)
    {
        $message = is_array($message) ? json_encode($message) ?: '' : $message;
        parent::__construct($message, $code, $previous);
    }
}
