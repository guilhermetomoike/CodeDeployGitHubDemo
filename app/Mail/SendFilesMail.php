<?php

namespace App\Mail;

use App\Models\Arquivo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class SendFilesMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $email;
    public Collection $arquivos;

    public function __construct(string $email, Collection $arquivos)
    {
        $this->email = $email;
        $this->arquivos = $arquivos;
    }

    public function build()
    {
        $lines[] = 'Conforme solicitado, segue anexo documentos solicitados.';

        $this
            ->from(config('mail.cc.contabilidade'), config('mail.from.name'))
            ->subject('Documentos medb')
            ->markdown('email.default', compact('lines'))
            ->with([$this->arquivos])
            ->to($this->email);

        $this->arquivos->each(function (Arquivo $arquivo) {
            $this->attachFromStorageDisk('s3', $arquivo->caminho, $arquivo->nome_original);
        });

        return $this;
    }
}
