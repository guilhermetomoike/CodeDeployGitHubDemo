<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $subject;
    public $with;
    public $attach;

    public function __construct($email, $subject = null, $with = null, $attach = null)
    {
        $this->email   = $email;
        $this->subject = $subject;
        $this->with    = $with;
        $this->attach  = $attach;
    }

    public function build()
    {
        $email = $this->from($this->email)
            ->view('test')
            ->subject($this->subject)
            ->with($this->with);

        collect($this->attach)->each(function ($item) use ($email) {
            $email->attach($item->getRealPath(), [
                'as' => $item->getClientOriginalName(),
                'mime' => $item->getMimeType(),
            ]);
        });

        return $email;
    }
}
