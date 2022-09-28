<?php

namespace App\Mail;

use App\Models\PreQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class PgblInformationMail
 *
 * Classe responsavel pela montagem em markdown e envio de email sobre aplicacao em pgbl
 *
 * @package App\Mail
 */
class PgblInformationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;
    /**
     * @var array
     */
    private $simulacao;

    private $sleep = 15;

    public function __construct(array $simulacao)
    {
        $this->replyTo('gestor01@medb.com.br');
        $this->cc('gestor02@medb.com.br');
        $this->onQueue('email');
        $this->to($simulacao['email']);
        $this->subject('Formas de Reduzir seu imposto de renda.');
        $this->replyTo('contato@medb.com.br');
        $this->simulacao = $simulacao;
    }

    public function tags()
    {
        return ['pgbl', 'cliente:' . $this->simulacao['cliente_id']];
    }

    public function build()
    {
        $nome = explode(' ', $this->simulacao['nome'])[0];
        $data['greeting'] = "Olá, {$nome}.";
        $data['simulacao'] = $this->simulacao;

        sleep($this->sleep);

        PreQueue::whereCliente_id($this->simulacao['cliente_id'])->update(['dispatched_at' => now()]);

        return $this->markdown('email.pgblsugestion', $data);
    }

}
