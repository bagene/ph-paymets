<?php

namespace Bagene\PhPayments\Exceptions;

class MethodNotFoundException extends \Exception
{
    public function __construct(string $message = '', int $code = 405, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
