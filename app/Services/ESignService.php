<?php


namespace App\Services;

use App\Events\ContratoAssinado;
use App\Models\Contrato;
use GuzzleHttp\Client;

class ESignService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.autentique.com.br',
            'headers' => ['Content-Type' => 'application/json']
        ]);
        return $this;
    }


    public static function send(Contrato $contrato)
    {
        $data = [
            "partes[0][email]" => $contrato->email,
            "partes[0][funcao]" => "assinar",
            "arquivo" => url($contrato->path),
            "nome" => "Contrato Medb Contabilidade e finanças",
            "rejeitavel" => false
        ];

        $response = (new static())->client
            ->post('documentos.json', $data)
            ->getBody()
            ->getContents();

        return true;
    }


    public function resend()
    {
        $uuid = '';
        $response = $this->client
            ->post("documentos/{$uuid}/reenviar.json")
            ->getBody()
            ->getContents();

        dd($response);
    }


    public function getAssinatura()
    {
        $token = '';
        $response = $this->client
            ->get("assinatura/{$token}.json")
            ->getBody()
            ->getContents();

        dd($response);
    }


    public function getDocumento()
    {
        $uuid = '';
        $response = $this->client
            ->get("documentos/{$uuid}.json")
            ->getBody()
            ->getContents();

        dd($response);
    }


    public function webhook($data)
    {
        $status = explode('.', $data['event'])[1];

        $contrato = Contrato::where(
            ['document_id' => $data['data']['document_id'], 'user_id' => $data['data']['user_id']]
        )->first();

        $contrato->update(['status' => $status]);

        event(new ContratoAssinado($contrato));

        return $contrato;
    }
}