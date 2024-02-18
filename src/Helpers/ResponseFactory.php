<?php

namespace Bagene\PhPayments\Helpers;

use Bagene\PhPayments\Requests\BaseResponse;
use Bagene\PhPayments\Requests\Response;
use Psr\Http\Message\ResponseInterface;

final class ResponseFactory
{
    public static function createResponse(string $responseClass, ResponseInterface $response): BaseResponse
    {
        try {
            /** @var BaseResponse $response */
            $response = new $responseClass($response);

            return $response;
        } catch (\Throwable $exception) {
            throw new \InvalidArgumentException('Response class must be an instance of ' . Response::class);
        }
    }
}
