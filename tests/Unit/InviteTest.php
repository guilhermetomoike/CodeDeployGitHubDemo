<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class InviteTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function leadProvider()
    {
        return [
            ['{ "leads":[ { "email":"hrafaelaf@gmail.com", "name":"Rafael Affonso", "custom_fields":{ "[CAMPO] FACULDADE":null, "[CAMPO] Nome do amigo":"amigo teste", "[CAMPO] E-mail do amigo":"teste@gmail.com", "[CAMPO] Telefone do amigo":"+55 (12) 31231-2312", "CPF":"101010101010101010101" } } ] }']
        ];
    }
}
