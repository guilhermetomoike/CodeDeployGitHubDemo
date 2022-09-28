<?php

namespace Modules\Invoice\Jobs;

use App\Models\Payer\PayerContract;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Invoice\Repositories\ContasReceberRepository;

class FaltantesContasReceberJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private PayerContract $payer;
    private bool $unique;

    public function __construct(PayerContract $payer, bool $unique)
    {
        $this->payer = $payer;
        $this->unique = $unique;
    }

    public function handle(ContasReceberRepository $contasReceberRepository)
    {
        $bool = true;
         if (isset(  $this->payer->contasrecebern)) {
                foreach (  $this->payer->contasrecebern as $c) {

                
                    if ($c->vencimento == Carbon::now()->format('Y-m-20')) {
                        $bool = false;
                    }
                }
            }

            if ($bool and isset(  $this->payer->id)) {

                $mescont = count(  $this->payer->contasrecebern);
                if ($mescont == 0) {
                    $valor =   $this->payer->plans[0]->price;


                    $contasReceberRepository->createContasReceber([
                        'vencimento' => Carbon::now()->format('Y-m-20'),
                        'valor' => (float)$valor,
                        'descricao' => 'Honorário mensal',
                        'payer_type' =>   $this->payer->getModelAlias(),
                        'payer_id' =>   $this->payer->id,
                    ]);
                } else {

                    foreach (  $this->payer->contasrecebern as $c) {

                        $c->vencimento = Carbon::now()->subMonth()->addMonth($mescont)->format('Y-m-20');
                        $c->save();
                        $mescont++;
                    }
                }
            }
    }
}
