<?php

namespace Modules\Invoice\Tests\Feature;

use Modules\Invoice\Entities\Fatura;
use Modules\Invoice\Entities\InvoiceStatus;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChangeWebhookTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     * @dataProvider getWebhookJson
     * @return void
     */
    public function testChangInvoiceStatusFromWebhook($data)
    {
        $request = json_decode($data, true);
        $fatura = $this->createFatura($request);

        $response = $this->withHeader('Authorization', config('services.iugu.webhook_token'))
            ->postJson('/webhook/iugu/mudanca-estado-fatura', $request);

        $response->assertStatus(200);

        $this->assertDatabaseHas('fatura', [
            'gatway_fatura_id' => $fatura->gatway_fatura_id,
            'status' => (new InvoiceStatus($request['data']['status']))->valueType()
        ]);
    }

    public function getWebhookJson()
    {
        return [
            'pago' => ['{ "event": "invoice.status_changed", "data": { "id": "93399BDC25E94835829B341E08FE0B65", "status": "paid", "account_id": "F9774DF8EA874AE181548D453A81690B", "payment_method": "iugu_bank_slip" } }'],
            'expired' => ['{ "event": "invoice.status_changed", "data": { "id": "93399BDC25E94835829B341E08FE0B65", "status": "expired", "account_id": "F9774DF8EA874AE181548D453A81690B", "payment_method": "iugu_bank_slip" } }'],
            'pending' => ['{ "event": "invoice.status_changed", "data": { "id": "93399BDC25E94835829B341E08FE0B65", "status": "pending", "account_id": "F9774DF8EA874AE181548D453A81690B", "payment_method": "iugu_bank_slip" } }'],
            'canceled' => ['{ "event": "invoice.status_changed", "data": { "id": "93399BDC25E94835829B341E08FE0B65", "status": "canceled", "account_id": "F9774DF8EA874AE181548D453A81690B", "payment_method": "iugu_bank_slip" } }'],
        ];
    }

    private function createFatura($request)
    {
        return Fatura::query()->create([
            'payer_id' => 74,
            'payer_type' => 'empresa',
            'subtotal' => 200,
            'gatway_fatura_id' => $request['data']['id'],
        ]);
    }
}
