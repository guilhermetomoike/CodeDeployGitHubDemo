<?php

namespace Modules\Invoice\Console;

use App\Models\Empresa;
use Illuminate\Console\Command;
use Modules\Invoice\Entities\Fatura;
use Modules\Invoice\Jobs\ChargeInvoiceWithCreditCardJob;

class ChargeInvoiceWithCreditCardCommand extends Command
{
    protected $name = 'invoice:charge';

    protected $description = 'Cobra faturas com cartão de credito cadastrado.';

    public function handle()
    {
        $faturas = Fatura::with(['payer' => function ($payer) {
            $payer->with(['cartao_credito' => function ($cartao_credito) {
                $cartao_credito->whereNotNull('forma_pagamento_gatway_id');
                $cartao_credito->where('principal', 1);
            }]);
        }])
            ->where('data_competencia', competencia_anterior())
            ->whereNotIn('status', ['pago', 'cancelado'])
            ->whereHasMorph('payer', Empresa::class, function ($payer) {
                $payer->whereHas('cartao_credito');
            })
            ->get();

        $faturas->each(function ($fatura) {
            dispatch(new ChargeInvoiceWithCreditCardJob($fatura));
        });
    }

}
