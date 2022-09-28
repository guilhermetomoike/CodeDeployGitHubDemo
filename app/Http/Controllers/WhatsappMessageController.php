<?php

namespace App\Http\Controllers;

use App\Jobs\SendSmsJob;

use App\Models\Empresa;
use App\Models\TwilioOutgoing;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class WhatsappMessageController
{
    private $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function incoming(Request $request)
    {
        $numero = cleanWappNum($request->post('From'));
        $receivedMessage = strtolower($request->post('Body'));

        if ($receivedMessage == 'guias' || Str::contains($receivedMessage, 'guias')) {
            Artisan::call('send-guia-twilio', ['numero' => $numero]);
        }
        //        else if ($receivedMessage == 'boleto2' || Str::contains($receivedMessage, 'boleto2')) {
        //            GuiaService::sendHonorarioVencidoByWappNumber($numero);
        //        }
        else if ($receivedMessage == 'ch20' || Str::contains($receivedMessage, 'CH20')) {
            Artisan::call('send-fatura-congelada-twilio', ['numero' => $numero]);
        }
        //        else if ($receivedMessage == 'guia2' || Str::contains($receivedMessage, 'guia2')) {
        //            GuiaService::sendGuiasByWappNumberVencimentoHoje($numero);
        //        }
        //        else if ($receivedMessage == 'cartao2' || Str::contains($receivedMessage, 'cartao2')) {
        //            ClienteService::sendDadosAcessoByWappNumber($numero);
        //        }
        else {
            $this->twilioService->send($numero, TwilioService::MSG_AUTOMATICA);
        }

        return response('received webhook', 200);
    }

    public function receiveStatus(Request $request)
    {
        TwilioOutgoing::query()->create($request->post());

        return response('received webhook', 200);
    }

    public function messagemTeste(Request $request)
    {
        $contatos = Empresa::query()
            ->join('clientes_empresas', 'clientes_empresas.empresas_id', 'empresas.id')
            ->join('clientes', 'clientes.id', 'clientes_empresas.clientes_id')
            ->join('contatos', 'contatos.contactable_id', 'clientes.id')
            ->where('contatos.contactable_type', 'cliente')
            ->where('contatos.tipo', 'celular')
            ->where('empresas.status_id', 100)->select('empresas.id', 'clientes.nome_completo', 'contatos.value')->get();

        $data = [];

        // return $this->validateNumber(preg_replace("/[^0-9]/", "",'(11)97574-3704'));
        foreach ($contatos as $item) {

            if (substr(preg_replace("/[^0-9]/", "", $item->value), 0, 2) == 55) {
                if (strlen(preg_replace("/[^0-9]/", "", $item->value)) == 13) {
                    $data[] = preg_replace("/[^0-9]/", "", $item->value);
                }
            } else {
                if (strlen("55" . preg_replace("/[^0-9]/", "", $item->value)) == 13) {
                    $data[] =   "55" . preg_replace("/[^0-9]/", "", $item->value);
                }
                // $data[] = $item->value;

            }
        }

        try {
            
            if ($request->get('whats')) {

                // $message = $this->twilioService->send($request->get('numero'), $request->get('mensagem'));
            } else {
                foreach ($data as $cel) {

                     SendSmsJob::dispatch($cel);
                }
      
            }


            return response()->json("sucesso", 200);
        } catch (\Exception $e) {
            return response()->json("error".$e, 200);
        }
    }

}
