<?php

namespace App\Jobs;


use App\Services\TwilioService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private  $cel;

    public function __construct($cel)
    {
        $this->onQueue('twilio');
        $this->cel = $cel;
    }

    public function handle(TwilioService $twilioService)
    {
        $twilioService->seedSMS(
            $this->cel,
            [
                "messagingServiceSid" => "MGa2beac8839a0e451f01c351426b6e1a0",
                "body" =>  "Parabéns pelo Dia do Médico! A MEDB agradece por participar da sua jornada. Que você continue a se preocupar apenas com o mais importante: salvar-vidas."
            ]
        );
    }
}
