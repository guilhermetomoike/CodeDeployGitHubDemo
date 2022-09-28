<?php


namespace App\Services\ApiAuxiliar;


use GuzzleHttp\Client;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiAuxiliarService
{
    /**
     * @var Client
     */
    private $Plugnotas;

    /**
     * AuxiliarService constructor.
     */
    public function __construct()
    {
        $this->Plugnotas = new Client([
            'base_uri' => 'https://api.plugnotas.com.br',
            'headers' => [
                'x-api-key' => env('API_KEY_PLUGNOTAS')
            ]
        ]);
    }

    public function consultaCnpj($cnpj)
    {
        try {
            $response = $this->Plugnotas->get("/cnpj/{$cnpj}")->getBody()->getContents();

            return json_decode($response);

        } catch (\Throwable $e) {
            throw new HttpException(400, 'Falha na comunicação com webservice. Tente mais tarde.');
        }
    }

    public function consultaHomologacao($codigo_ibge)
    {
        try {
            $response = $this->Plugnotas->get("/nfse/cidades/{$codigo_ibge}")->getBody()->getContents();

            return json_decode($response);

        } catch (\Throwable $e) {
            throw new HttpException(400, 'Falha na comunicação com webservice. Tente mais tarde.');
        }

    }

    public function consultaCep($cep)
    {
        try {
            $cep_info = zipcode($cep);
            if ($cep_info) {
                $cepObject = $cep_info->getObject();
                return $cepObject;
            }

            $consulta1 = consulta_cep1($cep);
            if ($consulta1) {
                return $consulta1;
            }

            abort(400);

        } catch (\Exception $e) {
            throw new HttpException(400, 'Falha na comunicação com webservice. Tente mais tarde.');
        }

    }
}
