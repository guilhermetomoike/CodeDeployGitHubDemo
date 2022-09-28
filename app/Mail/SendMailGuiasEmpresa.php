<?php

namespace App\Mail;

use App\Models\Guia;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailGuiasEmpresa extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $guias;

    /**
     * SendMailGuiasEmpresa constructor.
     * @param ?Collection $email : email replay to
     * @param Collection|null $guias : array de guias para enviar
     * @throws \Exception
     */
    public function __construct(?Collection $email, ?Collection $guias = null)
    {
        $this->email = $email;
        $this->validateEmail();
        $this->guias = $guias;
    }

    public function build()
    {
        $this->from(config('mail.cc.contabilidade'), config('mail.from.name'));
        $this->replyTo(config('mail.cc.contabilidade'));
        $this->cc(config('mail.cc.contabilidade'));
        $this->subject('Guias do mês');
        $this->view('templateEmail.guias');
        $this->with([$this->guias]);
        $this->to($this->email->toArray());

        $this->guias->each(function (Guia $guia) {
            $arquivo = $guia->arquivo;
            $this->attachFromStorageDisk('s3', $arquivo->caminho, $arquivo->nome_original);
        });

        return $this;
    }

    private function validateEmail()
    {
        if (!$this->email->count()) {
            throw new \Exception('Empresa sem email cadastrado para o envio');
        }
    }
}
