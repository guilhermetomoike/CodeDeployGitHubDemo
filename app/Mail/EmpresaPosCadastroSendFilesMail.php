<?php

namespace App\Mail;

use App\Models\Empresa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmpresaPosCadastroSendFilesMail extends Mailable
{
    use Queueable, SerializesModels;

    private Empresa $empresa;
    private string $message;
    private array $files;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Empresa $empresa, string $subject, string $message, array $files_ids)
    {
        $this->empresa = $empresa;
        $this->message = $message;
        $this->files_ids = $files_ids;
        $this->subject($subject);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['lines'] = [$this->message];

        $arquivos = $this->empresa->precadastro->arquivos;

        $files_ids = collect($this->files_ids);

        foreach ($arquivos as $arquivo) {
            if ($files_ids->contains($arquivo->id)) {
                $this->attachFromStorageDisk('s3', $arquivo->caminho, $arquivo->nome_original);
            }
        }

        return $this->markdown('email.default', $data);
    }
}
