<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\HtmlString;

class ClienteNovaSenhaMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $novaSenha;

    public function __construct(string $novaSenha)
    {
        $this->novaSenha = $novaSenha;
    }

    public function build()
    {
        $this->subject('Recuperação de senha');
        $lines[] = new HtmlString('Sua nova senha de acesso Medb é:<br/><strong>'.$this->novaSenha.'</strong>');
        $lines[] = 'Para sua segurança, altere essa senha no primeiro acesso.';
        return $this->markdown('email.default', compact('lines'));
    }
}
