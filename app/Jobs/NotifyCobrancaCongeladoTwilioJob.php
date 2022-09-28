<?php

namespace App\Jobs;

use App\Models\Empresa;
use App\Services\TwilioService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyCobrancaCongeladoTwilioJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $empresa;

    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;
        $this->onQueue('twilio');
    }

    public function handle(TwilioService $twilioService)
    {
        $numeros = $this->empresa->contatos()->whatsapp();
        $mensagem = 'Olá, este mês venceu a anuidade de manutenção da sua empresa (congelamento) enviamos o boleto por email, caso queira receber por aqui envie a palavra "CH20".';
        $twilioService->send($numeros, $mensagem);
    }
}
