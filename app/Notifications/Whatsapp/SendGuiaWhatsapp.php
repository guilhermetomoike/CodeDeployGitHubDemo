<?php

namespace App\Notifications\Whatsapp;

use App\Channels\Messages\WhatsAppMessage;
use App\Channels\WhatsappChannel;
use App\Models\GuiaLiberacao;
use App\Models\NotifiableContract;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class SendGuiaWhatsapp extends Notification
{
    use Queueable;

    private $guiaLiberacao;
    private $customNumber;

    public function __construct(GuiaLiberacao $guiaLiberacao, string $customNumber = null)
    {
        $this->guiaLiberacao = $guiaLiberacao;
        $this->customNumber = $customNumber;
    }

    public function via($notifiable)
    {
        return [WhatsappChannel::class];
    }

    public function toWhatsapp(NotifiableContract $notifiable)
    {
        $guias = $this->guiaLiberacao->guias()
            ->where('data_competencia', $this->guiaLiberacao->competencia)
            ->with('arquivos')
            ->get();
        $message = new WhatsAppMessage;
        $message->setMessage("já vou te encaminhar suas guias e boleto de honorários da empresa {$notifiable->razao_social}!");

        $guias->each(function ($guia) use (&$message) {
            $media_name = $guia->tipo . '.pdf';
            $temporaryUrl = Storage::disk()->TemporaryUrl(
                $guia->arquivo->caminho,
                now()->addHours(2),
                ['ResponseContentDisposition' => 'attachment; filename=' . $media_name,]
            );

            $message->setMedia($media_name, $temporaryUrl);
        });

        if ($this->customNumber) {
            $message->setRecipient($this->customNumber);
        }

        return $message;
    }
}
