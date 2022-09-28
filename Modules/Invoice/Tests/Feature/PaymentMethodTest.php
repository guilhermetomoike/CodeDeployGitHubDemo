<?php

namespace Modules\Invoice\Tests\Feature;

use App\Models\CartaoCredito;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Usuario;
use Modules\Invoice\Events\CreditCardWasCreated;
use Modules\Invoice\Events\PaymentMethodWasDeleted;
use Tests\JwtAuth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class PaymentMethodTest extends TestCase
{
    use JwtAuth;

    public function testListPaymentMethodsActingAsBackofficeUser()
    {
        $this->actingAs(factory(Usuario::class)->create());
        factory(Cliente::class, 3)->create()->each(function ($cliente) {
            $cliente->cartao_credito()->create(factory(CartaoCredito::class)->make()->toArray());
        });

        $response = $this->getJson('payment-methods');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => [
            [
                'payer_id',
                'payer_type',
                'cartao_credito' => [
                    [
                        'cartao_truncado',
                        'dono_cartao',
                        'vencimento'
                    ]
                ]
            ]
        ]]);
    }

    public function testListPaymentMethodsActingAsUser()
    {
        $this->actingAs(factory(Cliente::class)->create());

        $response = $this->getJson('payment-methods');

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Requisição não autorizada.']);
    }

    public function testCreatePaymentMethodWhenHavingEmpresa()
    {
        $this->expectsEvents(CreditCardWasCreated::class);
        $this->withoutJobs();

        $cliente = factory(Cliente::class)->create();
        $empresa = factory(Empresa::class)->create();
        $cliente->empresa()->save($empresa);

        $this->actingAs($cliente);

        $dataSet = [
            'cliente_id' => $cliente->id,
            'empresa_id' => $empresa->id,
            'token_cartao' => md5(123)
        ];

        $response = $this->postJson('/payment-methods', $dataSet);

        $response->assertStatus(201);
        $response->assertJsonPath('data.empresa_id', $empresa->id);
        $response->assertJsonPath('data.token_cartao', md5(123));
    }

    public function testNotAuthorizeShowPaymentMethodsByDiferentClientId()
    {
        $cliente = factory(Cliente::class)->create();
        $cliente2 = factory(Cliente::class)->create();
        $this->actingAs($cliente);

        $response = $this->getJson('payment-methods/cliente/' . $cliente2->id);

        $response->assertStatus(401);
    }

    public function testShowPaymentMethodsByClientId()
    {
        $cliente = factory(Cliente::class)->create();
        $cartao = $cliente->cartao_credito()->create(factory(CartaoCredito::class)->make()->toArray());

        $this->actingAs($cliente);

        $response = $this->getJson('payment-methods/cliente/' . $cliente->id);

        $response->assertStatus(200);
        $response->assertJsonPath('data.0.cartao_truncado', $cartao->cartao_truncado);
    }

    public function testDeletePaymentMethod()
    {
        $this->expectsEvents(PaymentMethodWasDeleted::class);
        $cliente = factory(Cliente::class)->create();
        $cartao = $cliente->cartao_credito()->create(factory(CartaoCredito::class)->make()->toArray());
        $this->actingAs($cliente);

        $response = $this->deleteJson('payment-methods/' . $cartao->id);

        $response->assertStatus(200);

        $this->assertSoftDeleted('cartao_credito', ['id' => $cartao->id,]);
    }
}
