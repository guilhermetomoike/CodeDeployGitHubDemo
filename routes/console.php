<?php

use App\Jobs\DownloadContratoAssinadoJob;
use App\Models\Empresa;
use App\Models\GuiaLiberacao;
use App\Notifications\AberturaEmpresas\ContratoAssinadoNotification;
use App\Repositories\ContratoRepository;
use App\Services\TwilioService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');


Artisan::command('remove-nfse-rejeitada', function () {
    \App\Models\Nfse\Nfse::query()->where('status', 'REJEITADO')->delete();
})->describe('Exclui registro de nfse rejeitada');


Artisan::command('send-guia-twilio {numero}', function ($numero) {
    $empresas_id = \App\Models\Contato::query()
        ->where('value', $numero)
        ->where('contactable_type', 'empresa')
        ->pluck('contactable_id');

    $guias_liberacao = GuiaLiberacao::query()
        ->whereIn('empresa_id', $empresas_id)
        ->where('competencia', competencia_anterior())
        ->with('empresa')
        ->get();

    if ($guias_liberacao->count() > 1) {
        (new TwilioService)->send($numero, 'Parece que você tem guias liberadas de mais de uma empresa.');
    }

    $guias_liberacao->each(function (GuiaLiberacao $guiaLiberacao) use ($numero) {
        $guiaLiberacao->empresa->notify(new \App\Notifications\Whatsapp\SendGuiaWhatsapp($guiaLiberacao, $numero));
    });
});


Artisan::command('update-contratos', function () {

    $documentKey = '<DOCUMENT KEU>';
    $contratoRepository = new ContratoRepository;
    $contrato = $contratoRepository->findByDocumentKey($documentKey);
    $empresa = $contrato->empresa;

    if ($empresa->status_id == 2) {
        $empresa->status_id = 3;
        $empresa->save();
    }

    $contrato->signed_at = now();
    $contrato->save();

    dispatch(new DownloadContratoAssinadoJob($contrato));

    $empresa->notify(new ContratoAssinadoNotification());
});

/*
'customer_email',
        'customer_cpf',
        'invitee_email',
        'invitee_name',
        'invitee_phone',
*/
Artisan::command('convite', function () {

    function getConvidadoId($convite)
    {
        if ($convite->invitee_email) {
            $contato = \App\Models\Contato::query()->firstWhere([
                'tipo' => 'email',
                'value' => $convite->invitee_email,
            ]);
        } else {
            $contato = \App\Models\Contato::query()->firstWhere([
                'tipo' => 'celular',
                'value' => normalizePhoneNumber($convite->invitee_phone),
            ]);
        }
        if (!$contato) return false;
        $convertido = $contato->responsavel;
        if ($convertido instanceof Empresa) {
            return $convertido->id;
        } else if ($convertido instanceof \App\Models\Cliente) {
            return $convertido->empresa[0]->id ?? null;
        }
        return false;
    }

    function getConvidadorId($convite)
    {
        if ($convite->customer_cpf)
            $customer = \App\Models\Cliente::query()->firstWhere('cpf', $convite->customer_cpf);
        else {
            $email_convidador = \App\Models\Contato::query()->firstWhere([
                'tipo' => 'email',
                'value' => $convite->customer_email,
            ]);
            $customer = $email_convidador ? $email_convidador->responsavel : null;
        }
        if ($customer instanceof Empresa) {
            return $customer->id;
        } else if ($customer instanceof \App\Models\Cliente) {
            return $customer->empresa[0]->id ?? null;
        }
        return false;
    }

    $convites = \App\Models\Invite::all();

    $result = [];
    foreach ($convites as $convite) {
        $empresaConvidadora = getConvidadorId($convite);
        if (in_array($empresaConvidadora, [1281, 1239])) continue;

        $empresaConvidada = getConvidadoId($convite);

        if ($empresaConvidadora && $empresaConvidada) {
            $result[] = ['convidador' => $empresaConvidadora, 'convertido' => $empresaConvidada];
//            \Modules\Invoice\Entities\FaturaSaldo::create([
//                'payer_id' => $empresaConvidadora,
//                'payer_type' => 'empresa',
//                'value' => -50,
//                'value_type' => 'percentual',
//                'competencia' => '2021-01-01',
//                'descricao' => 'Desconto por indicação de amigo.'
//            ]);
//            \Modules\Invoice\Entities\FaturaSaldo::create([
//                'payer_id' => $empresaConvidada,
//                'payer_type' => 'empresa',
//                'value' => -50,
//                'value_type' => 'percentual',
//                'competencia' => '2021-01-01',
//                'descricao' => 'Desconto por indicação de amigo.'
//            ]);
        }
    }
    dd(collect($result)->flatten()->values()->join(', '));
});
