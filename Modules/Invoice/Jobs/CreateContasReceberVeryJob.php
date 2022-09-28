<?php

namespace Modules\Invoice\Jobs;

use App\Models\Payer\PayerContract;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Invoice\Services\ContasReceber\CreateContasReceberService;
use Modules\Invoice\Services\ContasReceber\CreateContasReceberVeryService;

class CreateContasReceberVeryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private PayerContract $payer;
    private bool $unique;

    public function __construct(PayerContract $payer, bool $unique = false)
    {
        $this->payer = $payer;
        $this->unique = $unique;
    }

    public function handle(CreateContasReceberVeryService $contasReceberService)
    {
        $contasReceberService->createContasReceberByPayer($this->payer,  $this->unique);
    }
}
