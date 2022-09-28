<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\HtmlString;

class HoleriteSolicitacaoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->replyTo('gestaomedb@gmail.com');
        $this->subject('Solicitação de Holerites.');
        $this->to(trim($email));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        sleep(20);
        $data['lines'][] = 'Enviamos um questionário algumas vezes para planejamento do Imposto de Renda de Pessoa 
        Física de 2019/2020 através do celular do Tiago.';
        $data['lines'][] = "Aqueles que já responderam anteriormente orientamos de forma específica. Infelizmente não 
        dará mais tempo de orientar cada um de forma individualizada.";
        $data['lines'][] = new HtmlString('Desta forma precisamos para aqueles <strong>QUE TRABALHARAM COMO PESSOA FÍSICA</strong> que enviem para o 
        e-mail holerite@medb.com.br as cópias dos holerites do <strong>ANO TODO</strong> até dia 16/12.');
        $data['lines'][] = 'Mas fiquem tranquilos, o máximo que poderá acontecer é deixarem de economizar dinheiro.';
        $data['lines'][] = 'O não envio não irá ocasionar multas ou mais impostos.';
        $data['lines'][] = 'Isto faz parte do serviço completo e diferenciado que prestamos aos clientes Medb.';

        return $this->markdown('email.default', $data);
    }
}
