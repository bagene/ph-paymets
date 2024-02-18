<?php

namespace Bagene\PhPayments\Tests\Functional\Xendit;

use Bagene\PhPayments\Tests\Factories\XenditTestFactory;
use Bagene\PhPayments\Tests\ShouldMock;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;

class CreatePaymentActionTest extends TestCase
{
    use WithWorkbench, ShouldMock;

    protected function defineRoutes($router): void
    {
        $router->post('/api/xendit/create-payment', [
            'uses' => 'Workbench\App\Controllers\XenditPaymentsController@createPayment',
        ]);

        $router->get('/api/xendit/get-payment', [
            'uses' => 'Workbench\App\Controllers\XenditPaymentsController@getPayment',
        ]);
    }

    public function testCreatePayment(): void
    {
        $this->mockResponse(XenditTestFactory::INVOICE_RESPONSE);
        $response = $this->post('/api/xendit/create-payment', [
            'external_id' => '123',
            'amount' => 100000,
            'payer_email' => 'test@email.com',
            'description' => 'Test Description',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect();
    }

    public function testGetPayments(): void
    {
        $this->mockResponse(XenditTestFactory::INVOICE_RESPONSE);
        $response = $this->get('/api/xendit/get-payment');

        $response->assertStatus(200);
        $response->assertJson(json_decode(XenditTestFactory::INVOICE_RESPONSE, true));
    }
}
