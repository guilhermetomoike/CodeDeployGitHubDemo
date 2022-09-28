<?php

namespace Tests\Unit;

use App\Models\Cliente;
use App\Models\Invite;
use Tests\TestCase;

class TestInviteRelations extends TestCase
{
    public function testRelation()
    {
        $customer = Cliente::find(74);
        $customer->contatos()->delete();

        $customer->contatos()->create(['tipo' => 'email', 'value' => 'hrafaelaf@gmail.com', 'optin' => true]);

        $invite = Invite::query()->create([
            'customer_email' => 'hrafaelaf@gmail.com',
            'customer_cpf' => '06013595933',
            'invitee_email' => 'invitee@gmail.com',
            'invitee_name' => 'invitee name',
            'invitee_phone' => '123',
        ]);

        dd($invite->customer);

    }
}
