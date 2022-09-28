<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

class ErrataVencimentoGuiaNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $guias = $this->mapDataPadrao($notifiable);
        if (!$guias) return;

        $mail = new MailMessage;
        $mail->replyTo(config('mail.cc.contabilidade'));
        $mail->subject('Errata vencimento de impostos.');
        $mail->line('Segue correção das datas de vencimento, referente aos impostos enviados no email anterior.
As guias de impostos enviadas estão corretas, podendo serem pagas conforme abaixo:');

        $stringDates = '';
        foreach ($guias as $guia => $data) {
            $stringDates .= "{$guia} vencimento: {$data}<br/>";
        }
        $mail->line(new HtmlString($stringDates));

        return $mail;
    }

    private function mapDataPadrao($notifiable)
    {
        $data_padrao = DB::table('guias_datas_padrao')->get();

        $guias = $notifiable->guias()
            ->where('data_competencia', competencia_anterior())
            ->get();
        $tipos = $guias->pluck('tipo');

        $guias = [];
        foreach ($tipos as $tipo) {
            if (in_array($tipo, ['HOLERITE', 'ISS'])) continue;
            if ($tipo === 'HONORARIOS') {
                $guias[$tipo] = '20/08/2020';
            } else {
                $data_vencimento = $data_padrao->where('tipo', explode('/', $tipo)[0])->first()->data_vencimento;
                $guias[$tipo] = Carbon::parse($data_vencimento)->format('d/m/Y');
            }
        }
        return $guias;
    }

}
