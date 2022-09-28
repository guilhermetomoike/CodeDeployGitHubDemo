<?php

namespace Modules\Irpf\Tests\Feature;

use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Modules\Irpf\Emails\SendIrpfMail;
use Modules\Irpf\Notifications\ChargeIrpfNotification;
use Tests\JwtAuth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IrpfTest extends TestCase
{
    use JwtAuth;
    public int $cliente_id = 920;

    /**
     * @param $json
     * @dataProvider generateQtdReciboAndDeclaracao
     */
    public function testUpdateDeclaracaoWithLancamentoAndMakingCharge(string $json)
    {
        $data = json_decode($json, true);
        $user = Usuario::withTrashed()->find(44);
        $cliente_id = $this->cliente_id;

        $auth = $this->actingAs($user, 'api_usuarios');
        $response = $auth->json('patch', '/irpf/' . $cliente_id, $data);

        $response->assertStatus(200);
        // assert declaracao_irpf updated
        $this->assertDatabaseHas('declaracao_irpf', [
            'qtd_lancamento' => $data['qtd_lancamento'],
            'ganho_captal' => $data['ganho_captal'],
            'rural' => $data['rural'],
            'step' => 'finalizado',
        ]);

        // assert fatura created
        $this->assertDatabaseHas('fatura', [
            'subtotal' => 300,
            'payer_type' => 'cliente',
            'payer_id' => $cliente_id,
            'data_vencimento' => today()->addDays(5)->toDateString()
        ]);

        Notification::fake()->hasSent(Cliente::find($cliente_id), ChargeIrpfNotification::class);
    }

    public function generateQtdReciboAndDeclaracao()
    {
        return [
            [json_encode([
                'qtd_lancamento' => 2,
                'declaracao_id' => 1500,
                'recibo_id' => 1502,
                'rural' => false,
                'ganho_captal' => true
            ])]
        ];
    }

    /**
     * @param string $json
     * @dataProvider
     */
    public function testReceivePaymentAndSendDocuments(string $json)
    {
        $data = json_decode($json, true);
        $cliente_id = $this->cliente_id;

        $response = $this->postJson('/webhook/irpf/charge-notification', $data);

        $response->assertStatus(204);

        self::assertDatabaseHas('fatura', [
            'payer_id' => $cliente_id,
            'payer_type' => 'cliente',
            'status' => 'pago',
            'gatway_fatura_id' => $data['data']['id'],
        ]);

        Mail::fake()->assertSent(SendIrpfMail::class);
    }

    public function generateInvoicePaidJson()
    {
        return [
            ['{"event":"invoice.status_changed","data":{"id":"998BDDC74E474C228EE83A87A518A5E0","status":"paid","account_id":"F9774DF8EA874AE181548D453A81690B","payment_method":"iugu_bank_slip_test"}}']
        ];
    }

    /**
     * @param $json
     * @dataProvider generateQtdReciboAndDeclaracao
     */
    public function testUpdateDeclaracaoWithLancamentoWithoutCharge($json)
    {
        $this->cliente_id = 78;
        $data = json_decode($json, true);
        $user = Usuario::withTrashed()->find(44);
        $cliente_id = $this->cliente_id;

        $auth = $this->actingAs($user, 'api_usuarios');
        $response = $auth->json('patch', '/irpf/' . $cliente_id, $data);

        // assert declaracao_irpf updated
        $this->assertDatabaseHas('declaracao_irpf', [
            'qtd_lancamento' => $data['qtd_lancamento'],
            'ganho_captal' => $data['ganho_captal'],
            'rural' => $data['rural'],
            'step' => 'finalizado',
        ]);

        // assert fatura created
        $this->assertDatabaseMissing('fatura', [
            'payer_type' => 'cliente',
            'payer_id' => $cliente_id,
            'data_vencimento' => today()->addDays(5)->toDateString()
        ]);

        Mail::fake()->assertSent(SendIrpfMail::class);

        $response->assertStatus(200);
    }
}
