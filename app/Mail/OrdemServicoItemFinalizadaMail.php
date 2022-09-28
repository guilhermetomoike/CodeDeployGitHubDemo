<?php

namespace App\Mail;

use App\Models\OrdemServico\Arquivo;
use App\Models\OrdemServico\OrdemServicoItem;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrdemServicoItemFinalizadaMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var OrdemServicoItem
     */
    private $ordemServicoItem;

    private $mensagem;

    /**
     * Create a new message instance.
     *
     * @param OrdemServicoItem $ordemServicoItem
     * @param string|null $replay_to
     * @param string|null $mensagem
     */
    public function __construct(OrdemServicoItem $ordemServicoItem, string $replay_to = null, ?string $mensagem = null)
    {
        $this->mensagem = $mensagem;
        $this->ordemServicoItem = $ordemServicoItem;
        $this->replyTo($replay_to);
        $this->cc($replay_to);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $solicitacao_id = str_pad($this->ordemServicoItem->ordem_servico->id, 5, '0', STR_PAD_LEFT);
        $this->subject("Ordem de Serviço nº {$solicitacao_id} | " . config('app.name'));
        $this->ordemServicoItem->arquivos()->get()->each(function (\App\Models\Arquivo $arquivo) {
            $this->attachFromStorageDisk('s3', $arquivo->caminho, $arquivo->nome_original);
        });

        $data['lines'][] = "Sua solicitação {$this->ordemServicoItem->os_base->nome} já foi atendida.";
        if ($this->mensagem) {
            $data['lines'][] = $this->mensagem;
        }
        if (count($this->attachments) > 0) {
            $data['lines'][] = 'Os documentos gerados seguem anexos.';
        }
        $this->markdown('email.default', $data);
        return $this;
    }
}
