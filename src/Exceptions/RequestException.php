<?php

namespace Bagene\PhPayments\Exceptions;

class RequestException extends \Exception
{
    public function __construct($message = [], $code = 0, \Throwable $previous = null)
    {
        $message = is_array($message) ? json_encode($message) : $message;
        parent::__construct($message, $code, $previous);
    }
}
