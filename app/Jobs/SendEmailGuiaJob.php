<?php

namespace App\Jobs;

use App\Models\GuiaLiberacao;
use App\Mail\SendMailGuiasEmpresa;
use App\Services\SlackService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendEmailGuiaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private GuiaLiberacao $guaiLiberacao;

    public function __construct(GuiaLiberacao $guiaLiberacao)
    {
        $this->guaiLiberacao = $guiaLiberacao;
        $this->onQueue('email');
    }

    public function tags()
    {
        $tags = ['guias', 'empresa:' . $this->guaiLiberacao->empresa_id,];
        if($this->guaiLiberacao->erro_envio){
            array_push($tags, 'retentativa');
        }
        return $tags;
    }

    public function handle()
    {
        $emails = $this->guaiLiberacao->empresa
            ->contatos()
            ->email();

        $guias = $this->guaiLiberacao
            ->guias()
            ->where('data_competencia', $this->guaiLiberacao->competencia)
            ->with('arquivo')
            ->get();

        if ($guias->count() === 0) {
            $this->guaiLiberacao->update(['sem_guia' => 1]);
            return;
        }

        try {
            Mail::send(new SendMailGuiasEmpresa($emails, $guias));
            $this->guaiLiberacao->setEnviado();
        } catch (Throwable $throwable) {
            $this->handleException($throwable);
        }

        sleep(1);
    }

    public function handleException(Throwable $throwable)
    {
        $this->guaiLiberacao->setErroEnvio($throwable->getMessage());

        $this->fail($throwable);
    }

}
