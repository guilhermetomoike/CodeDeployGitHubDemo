<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DocumentMail extends Mailable
{
    use Queueable, SerializesModels;

    private $message;

    public function __construct($nome, $email, $subject, $mensagem, $attachments, $cc = [])
    {
        $this->message = $mensagem;
        $this->subject($subject);
        $this->to($email, explode(' ', trim($nome))[0]);

        foreach ($attachments as $file) {
            /** @var UploadedFile $file */
            $this->attach($file->getRealPath(), ['as' => $file->getClientOriginalName()]);
        }

        // adiciona emails em cópia e replyTo
        if (count(array_filter($cc)) > 0) {
            $this->replyTo($cc[0]);
            $this->cc($cc);
        }
    }


    public function build()
    {
        $data['greeting'] = "Olá, {$this->to[0]['name']},";
        $data['lines'][] = 'Este é um email automático gerado pelo nosso Sistema. =)';
        $data['lines'][] = $this->message;

        $this->cc('contabil@medb.com.br');

        return $this->markdown('email.default', $data);
    }

}
