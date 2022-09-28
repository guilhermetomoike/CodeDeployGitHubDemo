<?php

namespace App\Mail;

use App\Models\OsFileItem;
use App\Models\OsItem;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpFoundation\File\File;

class SendMailEmpresa extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $subject;
    public $with;
    public $attach;
    public $filesOsSelecteds;

    public function __construct($email, $subject = null, $with = null, $attach = null, $filesOsSelecteds = null)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->with = $with;
        $this->attach = $attach;
        $this->filesOsSelecteds = $filesOsSelecteds;
    }

    public function build()
    {
        $email = $this->from($this->email)
            ->view('test')
            ->subject($this->subject)
            ->with($this->with);

        collect($this->attach)->each(function ($item) use ($email) {
            $email->attach($item->getRealPath(), [
                'as'   => $item->getClientOriginalName(),
                'mime' => $item->getMimeType(),
            ]);
        });

        collect($this->filesOsSelecteds)->each(function ($item) use ($email) {
            $fileItem = OsFileItem::findOrFail($item);
            $file = new File($fileItem->getCaminhoCompleto());

            $email->attach($file->getRealPath(), [
                'as' => $file->getFilename(),
                'mime' => $file->getMimeType(),
            ]);

            $fileItem->update(['enviado_email' => 1]);
        });

        return $email;
    }
}
