<?php

namespace Bagene\PhPayments\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Stream;
use Illuminate\Foundation\Application;
use Psr\Http\Message\ResponseInterface;

/**
 * @property Application $app
 * @method createMock(string $class)
 */
trait ShouldMock
{
    /**
     * @param string|array<int, string> $responses
     */
    protected function mockResponse(string|array $responses): void
    {
        $clientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $responseMock = $this->getMockBuilder(ResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $rensponseMocks = [];

        if (is_array($responses)) {
            foreach ($responses as $response) {
                $rensponseMocks[] = $this->getMockResponse($response);
            }
        } else {
            $rensponseMocks[] = $this->getMockResponse($responses);
        }

        $clientMock->expects($this->atLeastOnce())
            ->method('request')
            ->willReturnOnConsecutiveCalls(...$rensponseMocks);

        $this->app->instance(Client::class, $clientMock);
        $this->app->bind(Client::class, function () use ($clientMock) {
            return $clientMock;
        });
    }

    private function getMockResponse(string $response): ResponseInterface
    {
        $responseMock = $this->getMockBuilder(ResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var resource $file */
        $file = fopen('data://text/plain,' . $response, 'r');

        $responseMock->expects($this->atLeastOnce())
            ->method('getBody')
            ->willReturn(new Stream($file));

        return $responseMock;
    }

    protected function mockResponseException(string $message, int $statusCode = 500): void
    {
        $clientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock->expects($this->once())
            ->method('request')
            ->willThrowException(new \Exception($message, $statusCode));

        $this->app->instance(Client::class, $clientMock);
        $this->app->bind(Client::class, function () use ($clientMock) {
            return $clientMock;
        });
    }
}
