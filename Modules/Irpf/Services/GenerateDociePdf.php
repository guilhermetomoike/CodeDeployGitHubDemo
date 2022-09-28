<?php

namespace Modules\Irpf\Services;

use App\Models\Cliente;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Database\Eloquent\Model;

class GenerateDociePdf
{
    public function execute(int $customerId)
    {
        $customer = Cliente::with('irpf')->find($customerId);
        $customerData = $this->getCustomerData($customer);
        $respostas = $this->getRespostas($customer);

        $view = view('irpf.docie', ['customer' => $customerData, 'respostas' => $respostas]);

        return PDF::loadHTML($view);
    }

    private function getCustomerData(Model $customer)
    {
        return [
            'name' => $customer->nome_completo,
            'cpf' => $customer->cpf,
            'companies' => $customer->empresa->implode('id', ', '),
        ];
    }

    private function getRespostas(Model $customer)
    {
        $respostas = $customer->irpf->resposta;

        return $respostas->map(fn($resposta) => [
            'pergunta' => $resposta->questionario->pergunta,
            'resposta' => $resposta->resposta,
            'quantidade' => $resposta->quantidade,
        ]);
    }
}
