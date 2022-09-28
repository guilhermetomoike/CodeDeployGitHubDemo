<?php

namespace App\Jobs;

use App\Models\Empresa;
use App\Models\Invite;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Invoice\Services\ContasReceber\CreateMovimentacaoService;

class GenerateInviteDiscountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Empresa $company;
    private Invite $invite;

    public function __construct(Empresa $company, Invite $invite)
    {
        $this->company = $company;
        $this->invite = $invite;
    }

    public function handle(CreateMovimentacaoService $createMovimentacaoService)
    {
        $plan = $this->company->plans->first();
        $contaReceber = $this
            ->company
            ->contasReceber()
            ->whereMonth('vencimento', Carbon::now()->month)
            ->whereYear('vencimento', Carbon::now()->year)
            ->first();

        if (!$plan) return;
        if (!$contaReceber) return;

        $amount = - ($plan->price / 2);
        $data = [
            'contaReceberId' => $contaReceber->id,
            'descricao' => 'Desconto por indicação',
            'valor' => $amount,
        ];

        $createMovimentacaoService->createMoviment($data);
        $this->invite->recebido();
    }
}
