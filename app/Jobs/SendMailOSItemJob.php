<?php

namespace App\Jobs;

use App\Mail\OrdemServicoItemFinalizadaMail;
use App\Models\Empresa;
use App\Models\OrdemServico\OrdemServicoItem;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendMailOSItemJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var OrdemServicoItem
     */
    private $ordemServicoItem;

    /**
     * @var Empresa
     */
    private $empresa;

    private $email;

    private $mensagem;

    /**
     * Create a new job instance.
     * @param OrdemServicoItem $ordemServicoItem
     * @param array $email
     * @param string $menssagem
     */
    public function __construct(OrdemServicoItem $ordemServicoItem, array $email, ?string $menssagem = null)
    {
        $this->ordemServicoItem = $ordemServicoItem;
        $this->mensagem = $menssagem;
        $this->empresa = $this->ordemServicoItem->ordem_servico->empresa;
        $this->email = array_filter($email);
        $this->onQueue('email');
    }

    public function tags()
    {
        return [
            'ordem_servico_item' . $this->ordemServicoItem->ordem_servico_id,
            'empresa:' . $this->empresa->id
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email['cliente'])->cc($this->email['cc'] ?? [])->send(
            new OrdemServicoItemFinalizadaMail($this->ordemServicoItem, $this->email['usuario'], $this->mensagem)
        );
    }
}
