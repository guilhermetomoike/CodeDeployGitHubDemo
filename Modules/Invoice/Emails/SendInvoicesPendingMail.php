<?php

namespace Modules\Invoice\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class SendInvoicesPendingMail extends Mailable
{
    use Queueable, SerializesModels;

    private Collection $faturas;
    private string $email;

    public function __construct(Collection $faturas, string $email)
    {
        $this->faturas = $faturas;
        $this->email = $email;
    }

    public function build()
    {
        $this->replyTo('gestor02@medb.com.br');
//        $this->cc('gestor02@medb.com.br');
        $this->subject('Honorários');
        $this->to($this->email);

        $links = null;
        foreach ($this->faturas as $fatura) {
            $competencia = $fatura->data_competencia->format('m-Y');
            $links .= '<a target="_blank" href="' . $fatura->fatura_url . '">' . 'Honorário ' . $competencia . '</a><br/>';

            $this->attach($fatura->fatura_url . '.pdf', [
                'as' => 'honorario_' . $competencia . '.pdf'
            ]);
        }

        $lines[] = 'Conforme solicitado, segue anexo os boletos de honorários.';
        $lines[] = new HtmlString('Caso prefira, pague online através do link: <br/>' . $links);

        return $this->markdown('email.default', compact('lines'));
    }
}
