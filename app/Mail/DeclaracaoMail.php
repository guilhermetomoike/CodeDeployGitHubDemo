<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeclaracaoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param $tipo string Renda ou Faturamento
     * @param $email string
     * @param $attachment mixed arquivo
     */
    public function __construct($tipo, $email, $attachment)
    {
        $this->subject("Declaração de {$tipo}");
        $this->to($email);
        $this->attachData($attachment, "declaracao{$tipo}.pdf");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['greeting'] = "Olá,";
        $data['lines'][] = 'Este é um email automático gerado pelo nosso Sistema. =)';
        $data['lines'][] = "Estamos lhe enviando anexo sua {$this->subject}. Qualquer dúvida, por favor, não hesite
        em entrar em contato conosco.";

        return $this->markdown('email.default', $data);
    }
}
