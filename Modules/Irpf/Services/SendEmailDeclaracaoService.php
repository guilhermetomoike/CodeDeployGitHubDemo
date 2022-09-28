<?php


namespace Modules\Irpf\Services;


use Illuminate\Support\Facades\Mail;
use Modules\Irpf\Emails\SendIrpfMail;
use Modules\Irpf\Entities\DeclaracaoIrpf;

class SendEmailDeclaracaoService
{
    private DeclaracaoIrpf $declaracaoIrpf;

    public function __construct(DeclaracaoIrpf $declaracaoIrpf)
    {
        $this->declaracaoIrpf = $declaracaoIrpf;
    }

    public function __invoke()
    {
        Mail::send(new SendIrpfMail($this->declaracaoIrpf));
        $this->declaracaoIrpf->update(['enviado' => date('Y-m-d H:i')]);
    }
}
