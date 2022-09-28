<?php

namespace Tests\Unit;

use App\Models\Empresa;
use App\Services\ContatoService;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfirmContactsTest extends TestCase
{
    use WithFaker;

    public function testThereIsContactsChanged()
    {
        $empresa = Empresa::find(74);
        $email = $empresa->contatos()->create([
            'value' => $this->faker->email,
            'tipo' => 'email',
            'optin' => 1,
        ]);

        $celular = $empresa->contatos()->create([
            'value' => $this->faker->phoneNumber,
            'tipo' => 'celular',
            'optin' => 1,
            'options' => [
                'is_whatsapp' => true
            ],
        ]);

        $cell1 = ['value' => $celular->value, 'tipo' => 'celular', 'optin' => 1, 'options' => ['is_whatsapp' => true],];
        $cell2 = ['value' => $this->faker->phoneNumber, 'tipo' => 'celular', 'optin' => 1, 'options' => ['is_whatsapp' => true],];
        $email1 = ['value' => $newEmail = $this->faker->email, 'tipo' => 'email', 'optin' => 1,];

        $service = new ContatoService();
        $result = $service->confirm('empresa', 74, [$email1, $cell1, $cell2]);

        self::assertNotFalse($result);
    }
}
