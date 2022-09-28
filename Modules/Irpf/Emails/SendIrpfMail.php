<?php

namespace Modules\Irpf\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Irpf\Entities\DeclaracaoIrpf;

class SendIrpfMail extends Mailable
{
    use Queueable, SerializesModels;

    private DeclaracaoIrpf $declaracaoIrpf;

    public function __construct(DeclaracaoIrpf $declaracaoIrpf)
    {
        $this->declaracaoIrpf = $declaracaoIrpf;
    }

    public function build()
    {
        $this->replyTo('gestaomedb@gmail.com');
        $this->cc('gestaomedb@gmail.com');
        $this->subject('Sua Declaração de Irpf');
        $this->to($this->declaracaoIrpf->cliente->routeNotificationForMail());

        foreach ($this->declaracaoIrpf->arquivos as $arquivo) {
            $this->attachFromStorageDisk('s3', $arquivo->caminho, $arquivo->nome);
        }

        $lines[] = 'Agradecemos a Confiança em nossos serviços.';
        // clientes nas empresas com id acima de 610 nao precisa reafirmar sobre a declaracao
        if ($this->declaracaoIrpf->cliente->empresa->contains('id', '<', 610)) {
            $lines[] = 'Estamos enviando a Declaração e Recibo referente ao Imposto de Renda Pessoa Física 2022-2021.';
        }
        $lines[] = 'A Medb proporciona a você uma experiência de comunidade, onde você tem acesso as melhores ferramentas e profissionais. Nosso objetivo é simplificar a gestão contábil, financeira e administrativa dos negócios de forma inteligente, tecnológica e humanizada.';
        return $this->markdown('email.default', compact('lines'));
    }
}
