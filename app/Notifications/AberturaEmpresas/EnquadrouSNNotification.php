<?php

namespace App\Notifications\AberturaEmpresas;

use App\Channels\CustomSlack;
use App\Services\SlackService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class EnquadrouSNNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return [CustomSlack::class];
    }

    public function toCustomSlack($notifiable)
    {
        return (new SlackService())
            ->addChannel(['#contabilidade', '#atendimento', 'rh', '#medb-executivo'])
            ->text("A empresa {$notifiable->id} foi enquadrada no simples nacional.")
            ->addField('Data', date('d/m/Y H:i'));
    }
}
