<?php

namespace Bagene\PhPayments\Helpers;

use Bagene\PhPayments\Requests\BaseResponse;
use Bagene\PhPayments\Requests\Response;
use Psr\Http\Message\ResponseInterface;

final class ResponseFactory
{
    public static function createResponse(string $responseClass, ResponseInterface $response): BaseResponse
    {
        $object = new $responseClass($response);

        if (!$object instanceof Response) {
            throw new \InvalidArgumentException('Response class must be an instance of ' . Response::class);
        }

        return $object;
    }
}
