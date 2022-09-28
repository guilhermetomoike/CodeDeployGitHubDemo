<?php

namespace App\Mail;

use App\Models\Empresa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class EmpresaCadastradaMail extends Mailable
{
    use Queueable, SerializesModels, InteractsWithQueue;

    private $empresa;
    private $token;

    /**
     * Create a new message instance.
     *
     * @param Empresa $empresa
     */
    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;
        $this->onQueue('email');

        $this->token = Auth::guard('api_clientes')->login($this->empresa->socioAdministrador[0]);

        $this->subject('Assinatura de contrato');
        $this->from('gestor03@medb.com.br', config('mail.from.name'));
        $this->to($this->empresa->socioAdministrador[0]->emails[0]->value);
        $this->replyTo('gestor03@medb.com.br');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $nome = $this->empresa->socioAdministrador[0]->getFirstName();
        $data['greeting'] = "Olá {$nome}!";

        $data['lines'] = [
            'Seja bem-vindo a MEDB!',
            'A partir desse momento, você será atendido pela nossa equipe de Onboarding.',
            'Entraremos em contato para agendar melhor horário para conversarmos sobre o processo de abertura e utilização do App da MEDB!',
            new HtmlString($this->badges()),
            'Estamos muito felizes por fazerem parte da MEDB!',
        ];

        return $this->markdown('email.default', $data);
    }

    private function badges()
    {
        $playStore = "<a style='margin-right: 10px' href='https://play.google.com/store/apps/details?id=br.com.medb&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1'><img height='40px' alt='Disponível no Google Play' src='" . url('storage/playstore-badge.png') . "'/></a>";
        $appStore = "<a href='https://apps.apple.com/br/app/medb-gest%C3%A3o/id1530957475'><img height='40px' alt='Disponível na App Store' src='" . url('storage/appstore-badge.png') . "'/></a>";
        return "<div style='margin: auto'>$playStore $appStore</div><br/>";
    }
}
