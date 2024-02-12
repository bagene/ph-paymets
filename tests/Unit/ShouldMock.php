<?php

namespace Bagene\PhPayments\Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Stream;
use Illuminate\Foundation\Application;
use Psr\Http\Message\ResponseInterface;

/**
 * @property Application|null $app
 * @method createMock(string $class)
 */
trait ShouldMock
{
    protected function mockResponse(string $response): void
    {
        $clientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $responseMock = $this->getMockBuilder(ResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $responseMock->expects($this->once())
            ->method('getBody')
            ->willReturn(new Stream(fopen('data://text/plain,' . $response, 'r')));

        $clientMock->expects($this->once())
            ->method('request')
            ->willReturn($responseMock);

        $this->app->instance(Client::class, $clientMock);
        $this->app->bind(Client::class, function () use ($clientMock) {
            return $clientMock;
        });
    }
}
